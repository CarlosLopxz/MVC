/**
 * JavaScript específico del controlador Dashboard
 * Este archivo se carga automáticamente cuando se accede al DashboardController
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard JS cargado correctamente');
    
    // Inicializar Dashboard
    initDashboard();
    
    // Event listeners específicos del dashboard
    bindDashboardEvents();
});

/**
 * Inicializar funcionalidades del dashboard
 */
function initDashboard() {
    // Verificar estado de la conexión a la base de datos
    checkDatabaseStatus();
    
    // Inicializar tooltips de Bootstrap si existen
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Animación de entrada para las cards
    animateCards();
}

/**
 * Bindear eventos específicos del dashboard
 */
function bindDashboardEvents() {
    // Evento para actualizar información del sistema
    const refreshBtn = document.getElementById('refresh-info');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function(e) {
            e.preventDefault();
            refreshSystemInfo();
        });
    }
    
    // Evento para mostrar/ocultar información técnica
    const techInfoToggle = document.querySelector('.tech-info-toggle');
    if (techInfoToggle) {
        techInfoToggle.addEventListener('click', function() {
            const techInfo = document.querySelector('.tech-info-details');
            if (techInfo) {
                techInfo.classList.toggle('d-none');
            }
        });
    }
}

/**
 * Verificar estado de la base de datos
 */
function checkDatabaseStatus() {
    const dbStatusElement = document.querySelector('.db-status-text');
    if (dbStatusElement) {
        const statusText = dbStatusElement.textContent.trim();
        
        if (statusText.includes('exitosa')) {
            dbStatusElement.classList.add('text-success');
            dbStatusElement.classList.remove('text-danger');
            
            // Agregar ícono de éxito
            const icon = document.createElement('i');
            icon.className = 'fas fa-check-circle me-2';
            dbStatusElement.insertBefore(icon, dbStatusElement.firstChild);
        } else {
            dbStatusElement.classList.add('text-danger');
            dbStatusElement.classList.remove('text-success');
            
            // Agregar ícono de error
            const icon = document.createElement('i');
            icon.className = 'fas fa-exclamation-triangle me-2';
            dbStatusElement.insertBefore(icon, dbStatusElement.firstChild);
        }
    }
}

/**
 * Animar entrada de las cards
 */
function animateCards() {
    const cards = document.querySelectorAll('.status-card, .card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

/**
 * Actualizar información del sistema
 */
function refreshSystemInfo() {
    showNotification('Actualizando información del sistema...', 'info');
    
    // Simular actualización (en un proyecto real harías una petición AJAX)
    setTimeout(() => {
        location.reload();
    }, 1000);
}

/**
 * Mostrar estadísticas del sistema en tiempo real
 */
function updateSystemStats() {
    // Esta función se puede usar para actualizar estadísticas en tiempo real
    // mediante WebSockets o peticiones AJAX periódicas
    
    const statsContainer = document.querySelector('.system-stats');
    if (statsContainer) {
        // Aquí irían las actualizaciones en tiempo real
        console.log('Actualizando estadísticas del sistema...');
    }
}

// Funciones auxiliares específicas del dashboard
const DashboardUtils = {
    
    /**
     * Formatear bytes a formato legible
     */
    formatBytes: function(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    },
    
    /**
     * Obtener información del navegador
     */
    getBrowserInfo: function() {
        return {
            userAgent: navigator.userAgent,
            language: navigator.language,
            platform: navigator.platform,
            cookieEnabled: navigator.cookieEnabled,
            onLine: navigator.onLine
        };
    },
    
    /**
     * Crear gráfico simple (si se necesita)
     */
    createSimpleChart: function(containerId, data) {
        // Implementación básica de gráfico
        console.log(`Creando gráfico en ${containerId}`, data);
    }
};
