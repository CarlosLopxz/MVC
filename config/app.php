<?php
/**
 * Configuración global de la aplicación
 */

return [ 

    'base_url' => 'http://localhost/mvc/', 
    // Información de la aplicación
    'app_name' => 'Leapcol MVC Framework',
    'app_version' => '1.0.0',
    'app_environment' => 'development', // development, testing, production
    'company_name' => 'Leapcol Software y Tecnología',
    'company_year' => '2025',
    'framework_author' => 'Leapcol Software y Tecnología',
    
    // Configuración de sesiones
    'session_lifetime' => 7200, // 2 horas en segundos
    'session_name' => 'mvc_session',
    
    // Configuración de upload
    'upload_path' => __DIR__ . '/../uploads/',
    'max_upload_size' => 10485760, // 10MB en bytes
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'],
    
    // Configuración de templates
    'default_template' => 'default',
    'cache_templates' => false,
    
    // Configuración de logging
    'log_errors' => true,
    'log_path' => __DIR__ . '/../logs/',
    
    // Configuración de seguridad
    'csrf_protection' => true,
    'xss_protection' => true,
    
    // Zona horaria
    'timezone' => 'America/Mexico_City',
    
    // Configuración de email (para futuras implementaciones)
    'email' => [
        'from_email' => 'noreply@mvc-framework.com',
        'from_name' => 'MVC Framework'
    ]
];
