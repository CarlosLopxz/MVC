<?php
require_once 'BaseController.php';

/**
 * Controlador Dashboard
 */
class DashboardController extends BaseController 
{
    public function index() 
    {
        // Verificar conexión a la base de datos
        $connectionStatus = $this->db->testConnection();
        
        // Datos para pasar a la vista
        $data = [
            'title' => 'Dashboard MVC',
            'mvc_status' => 'MVC exitoso',
            'db_status' => $connectionStatus ? 'Conexión a la base de datos exitosa' : 'Error en la conexión a la base de datos'
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
