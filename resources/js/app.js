import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// ======================
// FULLCALENDAR IMPORTS
// ======================
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';

// Exponer en window para usar en las vistas Blade
window.FullCalendar = {
    Calendar,
    dayGridPlugin,
    timeGridPlugin,
    interactionPlugin,
    listPlugin
};

// Array de plugins predeterminado
window.FullCalendarPlugins = [
    dayGridPlugin,
    timeGridPlugin,
    interactionPlugin,
    listPlugin
];