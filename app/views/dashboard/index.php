<?php 
// Cargar helpers
require_once __DIR__ . '/../../helpers/functions.php';

// Incluir header
require_once __DIR__ . '/../templates/header.php'; 
?>

<!-- Header profesional -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h2 mb-1 text-dark"><?php echo get_app_config()['app_name']; ?></h1>
                <p class="text-muted mb-0">Panel de administración del framework</p>
            </div>
            <span class="badge bg-danger fs-6">v<?php echo get_app_config()['app_version']; ?></span>
        </div>
    </div>
</div>

<!-- Cards de estado -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title mb-1">Estado del Framework</h6>
                        <p class="card-text text-success fw-semibold mb-0"><?php echo escape($mvc_status); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-database text-info" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title mb-1">Base de Datos</h6>
                        <p class="card-text fw-semibold mb-0 <?php echo strpos($db_status, 'exitosa') !== false ? 'text-success' : 'text-danger'; ?>">
                            <?php echo escape($db_status); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        
<!-- Tabla de información del sistema -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom">
        <h6 class="card-title mb-0 text-dark">
            <i class="fas fa-table me-2 text-danger"></i>
            Información del Sistema
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-muted">Componente</th>
                        <th class="text-muted">Valor</th>
                        <th class="text-muted">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="fab fa-php me-2 text-muted"></i>PHP Version</td>
                        <td class="fw-semibold"><?php echo phpversion(); ?></td>
                        <td><span class="badge bg-light text-dark border">Activo</span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-code me-2 text-muted"></i>Framework</td>
                        <td class="fw-semibold">MVC PHP Custom</td>
                        <td><span class="badge bg-light text-dark border">Funcionando</span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-tag me-2 text-muted"></i>Versión</td>
                        <td class="fw-semibold">1.0.0</td>
                        <td><span class="badge bg-light text-dark border">Estable</span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-cogs me-2 text-muted"></i>Entorno</td>
                        <td class="fw-semibold">Desarrollo</td>
                        <td><span class="badge bg-light text-dark border">Dev</span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-clock me-2 text-muted"></i>Zona Horaria</td>
                        <td class="fw-semibold"><?php echo date_default_timezone_get(); ?></td>
                        <td><span class="badge bg-light text-dark border">Configurado</span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-database me-2 text-muted"></i>Modelos</td>
                        <td class="fw-semibold">BaseModel</td>
                        <td><span class="badge bg-light text-dark border">Cargado</span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-eye me-2 text-muted"></i>Vistas</td>
                        <td class="fw-semibold">Templates</td>
                        <td><span class="badge bg-light text-dark border">Disponible</span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-gamepad me-2 text-muted"></i>Controladores</td>
                        <td class="fw-semibold">BaseController</td>
                        <td><span class="badge bg-light text-dark border">Activo</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Mensaje de bienvenida -->
<div class="alert alert-danger border-0 shadow-sm" role="alert">
    <div class="d-flex align-items-center">
        <div class="flex-shrink-0">
            <i class="fas fa-rocket text-danger" style="font-size: 1.5rem;"></i>
        </div>
        <div class="flex-grow-1 ms-3">
            <h6 class="alert-heading mb-1">¡Bienvenido al <?php echo get_app_config()['app_name']; ?>!</h6>
            <p class="mb-0 text-muted">
                Desarrollado por <strong class="text-dark"><?php echo get_app_config()['company_name']; ?></strong>. 
                El sistema está funcionando correctamente y listo para el desarrollo.
            </p>
        </div>
    </div>
</div>

<!-- Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<?php 
// Incluir footer
require_once __DIR__ . '/../templates/footer.php'; 
?>
