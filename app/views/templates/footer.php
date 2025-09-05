    </main> <!-- Fin del main content -->

    <!-- Footer Leapcol - Profesional y pegado al fondo -->
    <footer class="bg-light border-top py-3 mt-auto">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start">
                    <small class="text-muted">
                        &copy; <?= get_app_config()['company_year']; ?> 
                        <strong class="text-dark"><?php echo get_app_config()['company_name']; ?></strong>
                    </small>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        Framework v<?= get_app_config()['app_version']; ?> | 
                        Desarrollo de Software y Tecnología
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- JS Global del Framework -->
    <script src="<?= assets_url('js/app.js'); ?>"></script>
    
    
    <?php
    // Cargar JS personalizados del controlador
    $customJS = get_custom_js();
    foreach ($customJS as $jsFile): 
    ?>
    <script src="<?= $jsFile; ?>"></script>
    <?php endforeach; ?>
    

</body>
</html>
