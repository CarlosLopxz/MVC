<?php
require_once 'BaseController.php';

/**
 * Controlador Dashboard
 */
class DashboardController extends BaseController 
{
    public function index() 
    {
        // Verificar configuración y conexión a la base de datos
        $connectionStatus = false;
        $dbMessage = 'Base de datos no conectada';
        
        try {
            // Verificar si hay configuración de BD
            $dbConfig = require __DIR__ . '/../../config/database.php';
            
            if (empty($dbConfig['dbname'])) {
                $dbMessage = 'Base de datos no configurada';
            } else {
                $connectionStatus = $this->db->testConnection();
                $dbMessage = $connectionStatus ? 'Conexión a la base de datos exitosa' : 'Base de datos no conectada';
            }
        } catch (Exception $e) {
            // Detectar tipo de error específico
            if (strpos($e->getMessage(), 'Unknown database') !== false) {
                $dbMessage = 'La base de datos no existe';
            } elseif (strpos($e->getMessage(), 'Access denied') !== false) {
                $dbMessage = 'Credenciales de base de datos incorrectas';
            } else {
                $dbMessage = 'Base de datos no conectada';
            }
        }
        
        // Datos para pasar a la vista
        $data = [
            'title' => 'Dashboard MVC',
            'mvc_status' => 'MVC exitoso',
            'db_status' => $dbMessage,
            'db_connected' => $connectionStatus
        ];

        // Cargar la vista del dashboard (sin especificar index)
        $this->loadView('dashboard', $data);
    }

    /**
     * Método de ejemplo para mostrar información del sistema
     */
    public function info() 
    {
        $data = [
            'php_version' => phpversion(),
            'server_info' => $_SERVER['SERVER_SOFTWARE'] ?? 'No disponible',
            'mvc_version' => '1.0.0'
        ];

        $this->jsonResponse($data);
    }
}
