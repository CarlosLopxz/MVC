<?php
/**
 * Controlador Base - Funcionalidades comunes para todos los controladores
 */
class BaseController 
{
    protected $db;

    public function __construct() 
    {
        // Cargar la conexión a la base de datos
        require_once __DIR__ . '/../../config/Connection.php';
        $this->db = Database::getInstance();
    }

    /**
     * Cargar una vista
     */
    protected function loadView($view, $data = []) 
    {
        // Convertir el array de datos en variables
        extract($data);

        $basePath = __DIR__ . '/../views/';

        // Normalizar separadores
        $normalized = str_replace(['\\\\', '\\'], '/', $view);

        // Resolver ruta de la vista con las siguientes reglas:
        // 1) Si viene "carpeta/archivo" => carpeta/archivo.php
        // 2) Si viene solo "carpeta" => carpeta/index.php
        // 3) Si viene con extensión, respetarla
        $candidatePaths = [];

        // Si ya trae .php
        if (substr($normalized, -4) === '.php') {
            $candidatePaths[] = $basePath . $normalized;
        } else {
            // carpeta/archivo -> .php
            $candidatePaths[] = $basePath . $normalized . '.php';
            // carpeta -> carpeta/index.php
            $candidatePaths[] = $basePath . rtrim($normalized, '/') . '/index.php';
        }

        $viewPath = null;
        foreach ($candidatePaths as $path) {
            if (file_exists($path)) {
                $viewPath = $path;
                break;
            }
        }

        if ($viewPath) {
            require_once $viewPath;
        } else {
            throw new Exception("Vista no encontrada: $view");
        }
    }

    /**
     * Redireccionar a una URL
     */
    protected function redirect($url) 
    {
        header("Location: $url");
        exit();
    }

    /**
     * Respuesta JSON
     */
    protected function jsonResponse($data, $statusCode = 200) 
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    /**
     * Verificar si la petición es POST
     */
    protected function isPost() 
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Verificar si la petición es GET
     */
    protected function isGet() 
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}
