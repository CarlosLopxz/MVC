<?php
/**
 * Funciones Helper - Funciones útiles para toda la aplicación
 */

// Cargar configuración global
$app_config = null;

/**
 * Obtener configuración de la aplicación
 */
function get_app_config() 
{
    global $app_config;
    if ($app_config === null) {
        $app_config = require_once __DIR__ . '/../../config/app.php';
    }
    return $app_config;
}

/**
 * Escapar datos para prevenir XSS
 */
function escape($data) 
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Generar URL base (CONFIGURACIÓN MANUAL)
 */
function base_url($path = '') 
{
    $config = get_app_config();
    return rtrim($config['base_url'], '/') . '/' . ltrim($path, '/');
}

/**
 * Generar URL de assets (base_url + assets/)
 */
function assets_url($path = '') 
{
    $config = get_app_config();
    $base = rtrim($config['base_url'], '/');
    return $base . '/assets/' . ltrim($path, '/');
}

/**
 * Cargar layout (header, footer, navbar, modal, etc.)
 */
function layout($template) 
{
    $templatePath = __DIR__ . '/../views/templates/' . $template . '.php';
    
    if (file_exists($templatePath)) {
        require_once $templatePath;
        return true;
    }
    
    // Si está en subcarpeta (ej: modals/modal)
    $subfolderPath = __DIR__ . '/../views/templates/' . $template . '.php';
    if (file_exists($subfolderPath)) {
        require_once $subfolderPath;
        return true;
    }
    
    return false;
}

/**
 * Generar ruta de templates (views/templates/ + archivo.php)
 */
function templates_url($file = '') 
{
    $basePath = __DIR__ . '/../views/templates/';
    
    if (empty($file)) {
        return $basePath;
    }
    
    // Agregar .php si no lo tiene
    if (substr($file, -4) !== '.php') {
        $file .= '.php';
    }
    
    return $basePath . $file;
}

/**
 * Cargar modal (incluye el archivo directamente)
 */
function load_modal($file = '') 
{
    $basePath = __DIR__ . '/../views/templates/modals/';
    
    if (empty($file)) {
        return false;
    }
    
    // Agregar .php si no lo tiene
    if (substr($file, -4) !== '.php') {
        $file .= '.php';
    }
    
    $modalPath = $basePath . $file;
    
    if (file_exists($modalPath)) {
        require_once $modalPath;
        return true;
    }
    
    return false;
}

/**
 * Obtener ruta de modal (solo la ruta, sin incluir)
 */
function modals_path($file = '') 
{
    $basePath = __DIR__ . '/../views/templates/modals/';
    
    if (empty($file)) {
        return $basePath;
    }
    
    // Agregar .php si no lo tiene
    if (substr($file, -4) !== '.php') {
        $file .= '.php';
    }
    
    return $basePath . $file;
}

/**
 * Generar URL de medios/uploads (base_url + uploads/)
 */
function media_url($path = '') 
{
    $config = get_app_config();
    $base = rtrim($config['base_url'], '/');
    return $base . '/uploads/' . ltrim($path, '/');
}

/**
 * Generar URL de imágenes (base_url + assets/images/)
 */
function img_url($path = '') 
{
    $config = get_app_config();
    $base = rtrim($config['base_url'], '/');
    return $base . '/assets/images/' . ltrim($path, '/');
}

/**
 * Redireccionar
 */
function redirect($url) 
{
    header("Location: $url");
    exit();
}

/**
 * Mostrar mensaje de depuración
 */
function debug($data) 
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

/**
 * Formatear fecha
 */
function format_date($date, $format = 'Y-m-d H:i:s') 
{
    if ($date instanceof DateTime) {
        return $date->format($format);
    }
    
    if (is_string($date)) {
        $dateTime = new DateTime($date);
        return $dateTime->format($format);
    }
    
    return $date;
}

/**
 * Verificar si una variable está vacía
 */
function is_empty($value) 
{
    return empty($value) || trim($value) === '';
}

/**
 * Generar token CSRF
 */
function generate_csrf_token() 
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verificar token CSRF
 */
function verify_csrf_token($token) 
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Obtener nombre del controlador actual
 */
function get_current_controller() 
{
    global $current_controller;
    return $current_controller ?? 'dashboard';
}

/**
 * Obtener nombre del método actual
 */
function get_current_method() 
{
    global $current_method;
    return $current_method ?? 'index';
}

/**
 * Cargar JS específico del controlador
 */
function load_controller_js($controller = null, $method = null) 
{
    $controller = $controller ?? get_current_controller();
    $method = $method ?? get_current_method();
    
    $jsFiles = [];
    
    // JS general del controlador
    $controllerJs = strtolower($controller) . '.js';
    $controllerJsPath = __DIR__ . '/../../assets/js/' . $controllerJs;
    if (file_exists($controllerJsPath)) {
        $jsFiles[] = assets_url('js/' . $controllerJs);
    }
    
    // JS específico del método
    $methodJs = strtolower($controller) . '_' . strtolower($method) . '.js';
    $methodJsPath = __DIR__ . '/../../assets/js/' . $methodJs;
    if (file_exists($methodJsPath)) {
        $jsFiles[] = assets_url('js/' . $methodJs);
    }
    
    return $jsFiles;
}

/**
 * Cargar archivos JS específicos (desde el controlador)
 */
function load_js($files = []) 
{
    global $custom_js_files;
    if (!isset($custom_js_files)) {
        $custom_js_files = [];
    }
    
    foreach ($files as $file) {
        // Agregar .js si no lo tiene
        if (substr($file, -3) !== '.js') {
            $file .= '.js';
        }
        $custom_js_files[] = assets_url('js/' . $file);
    }
}

/**
 * Obtener archivos JS personalizados
 */
function get_custom_js() 
{
    global $custom_js_files;
    return $custom_js_files ?? [];
}

/**
 * Cargar CSS específico del controlador
 */
function load_controller_css($controller = null, $method = null) 
{
    $controller = $controller ?? get_current_controller();
    $method = $method ?? get_current_method();
    
    $cssFiles = [];
    
    // CSS general del controlador
    $controllerCss = strtolower($controller) . '.css';
    $controllerCssPath = __DIR__ . '/../../assets/css/' . $controllerCss;
    if (file_exists($controllerCssPath)) {
        $cssFiles[] = assets_url('css/' . $controllerCss);
    }
    
    // CSS específico del método
    $methodCss = strtolower($controller) . '_' . strtolower($method) . '.css';
    $methodCssPath = __DIR__ . '/../../assets/css/' . $methodCss;
    if (file_exists($methodCssPath)) {
        $cssFiles[] = assets_url('css/' . $methodCss);
    }
    
    return $cssFiles;
}

// ===================================================================
// FUNCIONES DE SEGURIDAD - LEAPCOL SOFTWARE Y TECNOLOGÍA
// ===================================================================

/**
 * Sanitizar entrada para prevenir SQL Injection
 */
function sanitize_sql($input) 
{
    if (is_array($input)) {
        return array_map('sanitize_sql', $input);
    }
    
    // Eliminar caracteres peligrosos para SQL
    $input = str_replace(["'", '"', ';', '--', '/*', '*/', 'xp_', 'sp_'], '', $input);
    
    // Trim y escape
    return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
}

/** 
 * Validar y sanitizar entero
 */
function sanitize_int($input, $min = null, $max = null) 
{
    $value = filter_var($input, FILTER_VALIDATE_INT);
    
    if ($value === false) {
        return false;
    }
    
    if ($min !== null && $value < $min) {
        return false;
    }
    
    if ($max !== null && $value > $max) {
        return false;
    }
    
    return $value;
}

/**
 * Validar y sanitizar email
 */
function sanitize_email($email) 
{
    $email = trim($email);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    }
    
    return false;
}

/**
 * Validar y sanitizar URL
 */
function sanitize_url($url) 
{
    $url = trim($url);
    $url = filter_var($url, FILTER_SANITIZE_URL);
    
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        return $url;
    }
    
    return false;
}

/**
 * Sanitizar string para uso seguro
 */
function sanitize_string($input, $max_length = 255) 
{
    if (!is_string($input)) {
        return '';
    }
    
    // Remover caracteres de control
    $input = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $input);
    
    // Trim y limitar longitud
    $input = trim($input);
    if (strlen($input) > $max_length) {
        $input = substr($input, 0, $max_length);
    }
    
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

/**
 * Limpiar array de datos de entrada
 */
function clean_input_array($data) 
{
    $clean = [];
    
    foreach ($data as $key => $value) {
        // Sanitizar la clave
        $clean_key = sanitize_string($key, 50);
        
        // Sanitizar el valor
        if (is_array($value)) {
            $clean[$clean_key] = clean_input_array($value);
        } else {
            $clean[$clean_key] = sanitize_string($value);
        }
    }
    
    return $clean;
}

/**
 * Validar token contra CSRF
 */
function validate_csrf($token = null) 
{
    $token = $token ?? ($_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '');
    
    if (empty($token)) {
        return false;
    }
    
    return verify_csrf_token($token);
}

/**
 * Generar consulta SQL segura con placeholders
 */
function build_safe_query($table, $conditions = [], $type = 'SELECT') 
{
    // Validar nombre de tabla
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
    
    $query = '';
    $params = [];
    
    switch (strtoupper($type)) {
        case 'SELECT':
            $query = "SELECT * FROM `{$table}`";
            break;
        case 'COUNT':
            $query = "SELECT COUNT(*) FROM `{$table}`";
            break;
        case 'DELETE':
            $query = "DELETE FROM `{$table}`";
            break;
    }
    
    if (!empty($conditions)) {
        $where_clauses = [];
        foreach ($conditions as $field => $value) {
            // Sanitizar nombre del campo
            $field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
            $placeholder = ':' . $field;
            
            $where_clauses[] = "`{$field}` = {$placeholder}";
            $params[$placeholder] = $value;
        }
        
        $query .= ' WHERE ' . implode(' AND ', $where_clauses);
    }
    
    return ['query' => $query, 'params' => $params];
}

/**
 * Loggear intento de ataque
 */
function log_security_event($event_type, $details = [], $ip = null) 
{
    $ip = $ip ?? ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $timestamp = date('Y-m-d H:i:s');
    
    $log_entry = [
        'timestamp' => $timestamp,
        'type' => $event_type,
        'ip' => $ip,
        'user_agent' => $user_agent,
        'details' => $details,
        'url' => $_SERVER['REQUEST_URI'] ?? ''
    ];
    
    // En producción, esto debería escribir a un archivo de log
    error_log('[SECURITY] ' . json_encode($log_entry));
    
    return $log_entry;
}

/**
 * Detectar patrones de inyección SQL
 */
function detect_sql_injection($input) 
{
    if (!is_string($input)) {
        return false;
    }
    
    $dangerous_patterns = [
        '/\bunion\b.*\bselect\b/i',
        '/\bselect\b.*\bfrom\b/i',
        '/\bdrop\b.*\btable\b/i',
        '/\binsert\b.*\binto\b/i',
        '/\bupdate\b.*\bset\b/i',
        '/\bdelete\b.*\bfrom\b/i',
        '/\bexec\b.*\(/i',
        '/\bscript\b.*\>/i',
        '/<.*script.*>/i',
        '/javascript:/i',
        '/vbscript:/i',
        '/onload=/i',
        '/onerror=/i'
    ];
    
    foreach ($dangerous_patterns as $pattern) {
        if (preg_match($pattern, $input)) {
            // Loggear el intento de ataque
            log_security_event('SQL_INJECTION_ATTEMPT', [
                'input' => substr($input, 0, 100),
                'pattern' => $pattern
            ]);
            return true;
        }
    }
    
    return false;
}

/**
 * Sanitizar entrada con detección de ataques
 */
function secure_input($input, $type = 'string') 
{
    // Detectar intentos de inyección
    if (detect_sql_injection($input)) {
        throw new Exception('Entrada inválida detectada - Intento de inyección bloqueado');
    }
    
    switch ($type) {
        case 'int':
            return sanitize_int($input);
        case 'email':
            return sanitize_email($input);
        case 'url':
            return sanitize_url($input);
        case 'string':
        default:
            return sanitize_string($input);
    }
}

/**
 * Validar múltiples campos de una vez
 */
function validate_fields($data, $rules) 
{
    $errors = [];
    $clean_data = [];
    
    foreach ($rules as $field => $field_rules) {
        $value = $data[$field] ?? null;
        
        // Verificar si es requerido
        if (isset($field_rules['required']) && $field_rules['required'] && empty($value)) {
            $errors[$field] = "El campo {$field} es obligatorio";
            continue;
        }
        
        // Si está vacío y no es requerido, continuar
        if (empty($value)) {
            $clean_data[$field] = null;
            continue;
        }
        
        try {
            // Sanitizar según el tipo
            $type = $field_rules['type'] ?? 'string';
            $clean_value = secure_input($value, $type);
            
            if ($clean_value === false && $type !== 'string') {
                $errors[$field] = "El campo {$field} tiene un formato inválido";
                continue;
            }
            
            // Validar longitud mínima
            if (isset($field_rules['min_length']) && strlen($clean_value) < $field_rules['min_length']) {
                $errors[$field] = "El campo {$field} debe tener al menos {$field_rules['min_length']} caracteres";
                continue;
            }
            
            // Validar longitud máxima
            if (isset($field_rules['max_length']) && strlen($clean_value) > $field_rules['max_length']) {
                $errors[$field] = "El campo {$field} no puede tener más de {$field_rules['max_length']} caracteres";
                continue;
            }
            
            $clean_data[$field] = $clean_value;
            
        } catch (Exception $e) {
            $errors[$field] = "El campo {$field} contiene datos inválidos";
            log_security_event('INVALID_INPUT', [
                'field' => $field,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    return [
        'is_valid' => empty($errors),
        'errors' => $errors,
        'data' => $clean_data
    ];
}
