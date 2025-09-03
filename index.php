<?php
/**
 * Punto de entrada principal del framework MVC
 */

// Iniciar sesión
session_start();

// Configuración de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir rutas de directorios
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');

// Cargar helpers
require_once APP_PATH . '/helpers/functions.php';

// Autoloader simple
spl_autoload_register(function ($className) {
    $directories = [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
        CONFIG_PATH . '/'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Router básico
function route() 
{
    // Obtener la URL solicitada
    $request = $_GET['url'] ?? '';
    $request = rtrim($request, '/');
    $request = filter_var($request, FILTER_SANITIZE_URL);
    
    // Dividir la URL en segmentos
    $segments = $request ? explode('/', $request) : ['dashboard'];
    
    // Determinar controlador y método
    $controllerName = ucfirst($segments[0] ?? 'dashboard') . 'Controller';
    $methodName = $segments[1] ?? 'index';
    
    // Establecer variables globales para el sistema de assets
    global $current_controller, $current_method;
    $current_controller = strtolower($segments[0] ?? 'dashboard');
    $current_method = strtolower($methodName);
    
    try {
        // Verificar si existe el controlador
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            
            // Verificar si existe el método
            if (method_exists($controller, $methodName)) {
                // Pasar parámetros adicionales si existen
                $params = array_slice($segments, 2);
                call_user_func_array([$controller, $methodName], $params);
            } else {
                throw new Exception("Método no encontrado: $methodName");
            }
        } else {
            throw new Exception("Controlador no encontrado: $controllerName");
        }
    } catch (Exception $e) {
        // Manejar errores
        http_response_code(404);
        echo "<h1>Error 404</h1>";
        echo "<p>Página no encontrada</p>";
        echo "<p>Error: " . escape($e->getMessage()) . "</p>";
        echo "<a href='" . base_url() . "'>Volver al inicio</a>";
    }
}

// Ejecutar el router
route();
