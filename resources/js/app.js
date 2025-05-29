import * as bootstrap from 'bootstrap';

// Инициализация компонентов Bootstrap при необходимости
document.addEventListener('DOMContentLoaded', function() {
    // Пример инициализации tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
