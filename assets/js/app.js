/**
 * JavaScript global del framework MVC
 * Este archivo se carga en todas las páginas del framework
 */

// Configuración global
const MVC_CONFIG = {
    debug: true,
    version: '1.0.0',
    name: 'MVC PHP Framework'
};

// Namespace principal del framework
window.MVC = {
    
    /**
     * Inicializar el framework
     */
    init: function() {
        console.log(`${MVC_CONFIG.name} v${MVC_CONFIG.version} iniciado`);
        
        // Configurar CSRF token si está disponible
        this.setupCSRF();
        
        // Configurar notificaciones
        this.setupNotifications();
        
        // Configurar manejo global de errores
        this.setupErrorHandling();
        
        // Inicializar componentes comunes
        this.initCommonComponents();
    },
    
    /**
     * Configurar token CSRF
     */
    setupCSRF: function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            // Configurar AJAX para incluir token CSRF automáticamente
            if (typeof $ !== 'undefined') {
                $.ajaxSetup({
                    beforeSend: function(xhr, settings) {
                        if (!/^(GET|HEAD|OPTIONS|TRACE)$/i.test(settings.type) && !this.crossDomain) {
                            xhr.setRequestHeader("X-CSRFToken", csrfToken.getAttribute('content'));
                        }
                    }
                });
            }
        }
    },
    
    /**
     * Configurar sistema de notificaciones
     */
    setupNotifications: function() {
        // Ya existe la función showNotification en footer.php
        // Aquí podríamos extenderla o configurarla
        if (typeof showNotification === 'function') {
            console.log('Sistema de notificaciones disponible');
        }
    },
    
    /**
     * Configurar manejo global de errores
     */
    setupErrorHandling: function() {
        window.addEventListener('error', function(e) {
            if (MVC_CONFIG.debug) {
                console.error('Error JavaScript:', e.error);
            }
            
            // Aquí podrías enviar errores a un servicio de logging
            MVC.logError('JavaScript Error', e.error);
        });
        
        // Capturar errores de promesas no capturadas
        window.addEventListener('unhandledrejection', function(e) {
            if (MVC_CONFIG.debug) {
                console.error('Promise rechazada no capturada:', e.reason);
            }
            
            MVC.logError('Unhandled Promise Rejection', e.reason);
        });
    },
    
    /**
     * Inicializar componentes comunes
     */
    initCommonComponents: function() {
        // Inicializar tooltips de Bootstrap
        this.initBootstrapComponents();
        
        // Configurar formularios
        this.setupForms();
        
        // Configurar navegación
        this.setupNavigation();
    },
    
    /**
     * Inicializar componentes de Bootstrap
     */
    initBootstrapComponents: function() {
        // Tooltips
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Popovers
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        }
    },
    
    /**
     * Configurar formularios
     */
    setupForms: function() {
        // Validación básica de formularios
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
        
        // Auto-submit en campos de búsqueda
        const searchInputs = document.querySelectorAll('input[data-auto-submit]');
        searchInputs.forEach(function(input) {
            let timeout;
            input.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    input.form.submit();
                }, 500);
            });
        });
    },
    
    /**
     * Configurar navegación
     */
    setupNavigation: function() {
        // Marcar enlace activo en la navegación
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        
        navLinks.forEach(function(link) {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
        
        // Smooth scrolling para anchors
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = link.getAttribute('href');
                if (href !== '#') {
                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    },
    
    /**
     * Realizar petición AJAX
     */
    ajax: function(options) {
        const defaults = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };
        
        const config = Object.assign({}, defaults, options);
        
        return fetch(config.url, config)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .catch(error => {
                this.logError('AJAX Error', error);
                throw error;
            });
    },
    
    /**
     * Registrar error
     */
    logError: function(type, error) {
        // En producción, esto enviaría errores a un servicio de logging
        if (MVC_CONFIG.debug) {
            console.group(`🚨 ${type}`);
            console.error(error);
            console.trace();
            console.groupEnd();
        }
        
        // Aquí podrías enviar a un endpoint de logging:
        // this.ajax({
        //     url: '/api/log-error',
        //     method: 'POST',
        //     body: JSON.stringify({type, error: error.toString()})
        // });
    },
    
    /**
     * Utilidades
     */
    utils: {
        
        /**
         * Formatear fecha
         */
        formatDate: function(date, format = 'YYYY-MM-DD') {
            const d = new Date(date);
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            
            return format
                .replace('YYYY', year)
                .replace('MM', month)
                .replace('DD', day);
        },
        
        /**
         * Debounce function
         */
        debounce: function(func, wait, immediate) {
            let timeout;
            return function executedFunction() {
                const context = this;
                const args = arguments;
                
                const later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                
                const callNow = immediate && !timeout;
                
                clearTimeout(timeout);
                
                timeout = setTimeout(later, wait);
                
                if (callNow) func.apply(context, args);
            };
        },
        
        /**
         * Throttle function
         */
        throttle: function(func, limit) {
            let lastFunc;
            let lastRan;
            return function() {
                const context = this;
                const args = arguments;
                if (!lastRan) {
                    func.apply(context, args);
                    lastRan = Date.now();
                } else {
                    clearTimeout(lastFunc);
                    lastFunc = setTimeout(function() {
                        if ((Date.now() - lastRan) >= limit) {
                            func.apply(context, args);
                            lastRan = Date.now();
                        }
                    }, limit - (Date.now() - lastRan));
                }
            }
        },
        
        /**
         * Generar UUID simple
         */
        generateUUID: function() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                const r = Math.random() * 16 | 0;
                const v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }
    }
};

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    MVC.init();
});

// Exponer algunas funciones globalmente para compatibilidad
window.formatDate = MVC.utils.formatDate;
window.debounce = MVC.utils.debounce;
window.throttle = MVC.utils.throttle;
