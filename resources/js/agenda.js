document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendario');

    if (!calendarEl) return;

    const calendar = new FullCalendar.Calendar(calendarEl, {

        plugins: window.FullCalendarPlugins,

        locale: 'es',

        initialView: 'dayGridMonth',

        height: 'auto',

        editable: true,
        selectable: true,

        displayEventTime: true,

        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },

        buttonText: {
            today: 'Hoy',
            month: 'Mes'
        },

        events: {
            url: '/api/citas',
            method: 'GET',
            failure: function () {
                Swal.fire('Error', 'No se pudieron cargar las citas', 'error');
            }
        },

        eventContent: function(arg) {

            let hora = '';

            if(arg.event.start){
                hora = arg.event.start.toLocaleTimeString('es-ES', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });
            }

            let estado = arg.event.extendedProps.estado || '';
            let tipo   = arg.event.extendedProps.tipo || '';

            return {
                html: `
                    <div style="font-size:11px; line-height:1.2; padding:2px;">
                        <div style="font-weight:bold;">
                            ${hora}
                        </div>

                        <div>
                            ${arg.event.title}
                        </div>

                        <div style="font-size:10px;">
                            ${estado}
                        </div>

                        <div style="font-size:10px;">
                            ${tipo}
                        </div>
                    </div>
                `
            };
        },

        eventDrop: function(info) {

    let estado = info.event.extendedProps.estado || '';

    // Bloquear completadas/canceladas
    if (estado === 'completada' || estado === 'cancelada') {

        info.revert();

        Swal.fire(
            'No permitido',
            'Esta cita ya no puede reprogramarse.',
            'warning'
        );

        return;
    }

    let fechaNueva = new Date(info.event.start);
    let hoy = new Date();

    hoy.setHours(0,0,0,0);

    // No permitir fechas anteriores
    if (fechaNueva < hoy) {

        info.revert();

        Swal.fire(
            'Fecha inválida',
            'No puedes mover citas a fechas pasadas.',
            'warning'
        );

        return;
    }

    // Día semana
    let dia = fechaNueva.getDay(); // 0 domingo

    let hora = fechaNueva.getHours();
    let minutos = fechaNueva.getMinutes();

    let decimal = hora + (minutos / 60);

    // Domingo cerrado
    if (dia === 0) {

        info.revert();

        Swal.fire(
            'Cerrado',
            'No se atiende los domingos.',
            'warning'
        );

        return;
    }

    // Lunes a viernes
    if (dia >= 1 && dia <= 5) {

        let valido =
            (decimal >= 8 && decimal < 12) ||
            (decimal >= 14 && decimal < 18);

        if (!valido) {

            info.revert();

            Swal.fire(
                'Horario inválido',
                'Horario: 8am-12pm y 2pm-6pm',
                'warning'
            );

            return;
        }
    }

    // Sábado
    if (dia === 6) {

        if (!(decimal >= 8 && decimal < 12)) {

            info.revert();

            Swal.fire(
                'Horario inválido',
                'Sábado: 8am a 12pm',
                'warning'
            );

            return;
        }
    }

    // CONTINÚA TU MODAL NORMAL
    Swal.fire({
        title: 'Reprogramar cita',
        text: '¿Deseas modificar también la hora?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {

        if(result.isConfirmed){

            const fecha = info.event.startStr.substring(0,10);

fetch('/api/citas/horarios-disponibles?fecha=' + fecha)
.then(r => r.json())
.then(horas => {

    if(horas.length === 0){

        info.revert();

        Swal.fire(
            'Sin cupos',
            'No hay horarios disponibles ese día.',
            'warning'
        );

        return;
    }

    let opciones = {};

    horas.forEach(h => {
        opciones[h] = h;
    });

    Swal.fire({
        title: 'Seleccione nueva hora',
        input: 'select',
        inputOptions: opciones,
        inputPlaceholder: 'Hora disponible',
        showCancelButton: true,
        confirmButtonText: 'Guardar'
    }).then((horaResult) => {

        if(horaResult.isConfirmed){

            enviarMovimiento(
                info,
                fecha,
                horaResult.value + ':00'
            );

        } else {

            info.revert();
        }

    });

});

        } else {

            const fecha = info.event.startStr.substring(0,10);

            const horaOriginal =
                info.event.extendedProps.hora_original;

            enviarMovimiento(
                info,
                fecha,
                horaOriginal
            );
        }

    });

},

        eventClick: function(info) {

            const cita = info.event.extendedProps;
            const estado = cita.estado || '';

            let hora = info.event.start.toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit'
            });

            Swal.fire({
                title: info.event.title,
                html: `
                    <div style="text-align:left;">
                        <p><b>Hora:</b> ${hora}</p>
                        <p><b>Estado:</b> ${estado}</p>
                        <p><b>Tipo:</b> ${cita.tipo || 'Consulta'}</p>
                        <p><b>Motivo:</b> ${cita.motivo || '-'}</p>
                    </div>
                `,
                showCancelButton: true,

                showDenyButton:
                    estado !== 'cancelada' &&
                    estado !== 'completada',

                confirmButtonText:
                    estado === 'pendiente'
                    ? 'Confirmar'
                    : estado === 'confirmada'
                    ? 'Completar'
                    : 'Cerrar',

                denyButtonText: 'Cancelar',

                confirmButtonColor:
                    estado === 'pendiente'
                    ? '#3b82f6'
                    : '#10b981',

                denyButtonColor: '#ef4444'
            }).then((result) => {

                if(result.isConfirmed){

                    if(estado === 'pendiente'){
                        cambiarEstado(
                            info.event.id,
                            'confirmada',
                            calendar
                        );
                    }

                    if(estado === 'confirmada'){
                        cambiarEstado(
                            info.event.id,
                            'completada',
                            calendar
                        );
                    }

                }

                if(result.isDenied){

                    cambiarEstado(
                        info.event.id,
                        'cancelada',
                        calendar
                    );

                }

            });

        }

    });

    calendar.render();

    window.calendar = calendar;

});

function enviarMovimiento(info, fecha, hora)
{
    console.log('Enviando movimiento:', {id: info.event.id, fecha: fecha, hora: hora});

    fetch('/api/citas/mover', {
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':
            document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            id: info.event.id,
            fecha: fecha,
            hora: hora
        })
    })
    .then(r => {
        console.log('Respuesta fetch:', r);
        return r.json();
    })
    .then(data => {
        console.log('Data respuesta:', data);

        if(data.success){

            Swal.fire(
                'Correcto',
                data.message,
                'success'
            );

            window.calendar.refetchEvents();

        } else {

            info.revert();

            Swal.fire(
                'Error',
                data.message || 'No se pudo actualizar',
                'error'
            );
        }

    })
    .catch(error => {
        console.error('Error en fetch:', error);

        info.revert();

        Swal.fire(
            'Error',
            'Problema de conexión',
            'error'
        );

    });
}

function cambiarEstado(id, estado, calendar)
{
    fetch('/api/citas/' + id + '/estado', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':
                document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            estado: estado
        })
    })
    .then(r => r.json())
    .then(() => {

        Swal.fire(
            'Actualizado',
            'Estado cambiado correctamente',
            'success'
        );

        calendar.refetchEvents();

    })
    .catch(() => {

        Swal.fire(
            'Error',
            'No se pudo actualizar el estado',
            'error'
        );

    });
}