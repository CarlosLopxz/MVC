    </main> <!-- Fin del main content -->

    <!-- Footer Leapcol - Profesional y pegado al fondo -->
    <footer class="bg-light border-top py-3 mt-auto">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start">
                    <small class="text-muted">
                        &copy; <?php echo get_app_config()['company_year']; ?> 
                        <strong class="text-dark"><?php echo get_app_config()['company_name']; ?></strong>
                    </small>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        Framework v<?php echo get_app_config()['app_version']; ?> | 
                        Desarrollo de Software y Tecnología
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JS Global del Framework -->
    <script src="<?php echo assets_url('js/app.js'); ?>"></script>
    
    <?php
    // Cargar JS específicos del controlador
    $controllerJS = load_controller_js();
    foreach ($controllerJS as $jsFile): 
    ?>
    <script src="<?php echo $jsFile; ?>"></script>
    <?php endforeach; ?>
    
    <!-- Custom JS -->
    <script>
        // Función para mostrar notificaciones con Bootstrap 5
        function showNotification(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(alertDiv);
            
            // Auto-dismiss después de 3 segundos
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 3000);
        }
        
        // Obtener icono según el tipo de notificación
        function getIconForType(type) {
            const icons = {
                'success': 'check-circle',
                'danger': 'exclamation-triangle',
                'warning': 'exclamation-triangle',
                'info': 'info-circle',
                'primary': 'info-circle',
                'secondary': 'info-circle'
            };
            return icons[type] || 'info-circle';
        }
        
        // Variables globales para el controlador actual
        window.CURRENT_CONTROLLER = '<?php echo get_current_controller(); ?>';
        window.CURRENT_METHOD = '<?php echo get_current_method(); ?>';
    </script>
</body>
</html>
