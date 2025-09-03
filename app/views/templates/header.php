<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? escape($title) : get_app_config()['app_name']; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Tema Leapcol -->
    <link href="<?php echo assets_url('css/leapcol.css'); ?>" rel="stylesheet">
    
    <!-- CSS específicos del controlador -->
    <?php
    $controllerCSS = load_controller_css();
    foreach ($controllerCSS as $cssFile): 
    ?>
    <link href="<?php echo $cssFile; ?>" rel="stylesheet">
    <?php endforeach; ?>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar Leapcol -->
    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo base_url(); ?>">
                <img src="<?php echo assets_url('images/logo.png'); ?>" alt="Leapcol" class="me-3" style="height: 100px;">
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-4 flex-grow-1">
