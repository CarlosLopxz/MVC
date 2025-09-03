<?php
/**
 * Modelo Base - Funcionalidades comunes para todos los modelos
 * Desarrollado por Leapcol Software y Tecnología
 * Incluye protección avanzada contra SQL Injection
 */
class BaseModel 
{
    protected $db;
    protected $table;
    protected $fillable = []; // Campos permitidos para operaciones masivas
    protected $guarded = ['id', 'created_at', 'updated_at']; // Campos protegidos

    public function __construct() 
    {
        // Cargar helpers para funciones de seguridad
        require_once __DIR__ . '/../helpers/functions.php';
        
        // Cargar la conexión a la base de datos
        require_once __DIR__ . '/../../config/Connection.php';
        $this->db = Database::getInstance()->getConnection();
        
        // Validar que se haya definido la tabla
        if (empty($this->table)) {
            throw new Exception('Debe definir la propiedad $table en ' . get_class($this));
        }
        
        // Sanitizar nombre de tabla
        $this->table = $this->sanitizeTableName($this->table);
    }
    
    /**
     * Sanitizar nombre de tabla/campo
     */
    private function sanitizeTableName($name) 
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $name);
    }
    
    /**
     * Validar campos contra whitelist
     */
    private function validateFields($data) 
    {
        $clean_data = [];
        
        foreach ($data as $field => $value) {
            // Sanitizar nombre del campo
            $clean_field = $this->sanitizeTableName($field);
            
            // Verificar si está en la lista de campos protegidos
            if (in_array($clean_field, $this->guarded)) {
                continue; // Saltar campos protegidos
            }
            
            // Si hay whitelist, verificar que el campo esté permitido
            if (!empty($this->fillable) && !in_array($clean_field, $this->fillable)) {
                continue; // Saltar campos no permitidos
            }
            
            // Sanitizar el valor
            $clean_data[$clean_field] = sanitize_string($value);
        }
        
        return $clean_data;
    }

    /**
     * Obtener todos los registros
     */
    public function findAll() 
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Obtener un registro por ID
     */
    public function findById($id) 
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Crear un nuevo registro
     */
    public function create($data) 
    {
        // Validar y limpiar los campos de entrada
        $data = $this->validateFields($data);
        if (empty($data)) {
            throw new Exception('No hay campos válidos para insertar');
        }
        
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        return $stmt->execute();
    }

    /**
     * Actualizar un registro
     */
    public function update($id, $data) 
    {
        // Sanitizar ID
        $id = sanitize_int($id, 1);
        if ($id === false) {
            throw new Exception('ID inválido para actualización');
        }
        
        // Validar y limpiar los campos de entrada
        $data = $this->validateFields($data);
        if (empty($data)) {
            throw new Exception('No hay campos válidos para actualizar');
        }
        
        $setClause = '';
        foreach (array_keys($data) as $column) {
            $setClause .= "$column = :$column, ";
        }
        $setClause = rtrim($setClause, ', ');
        
        $stmt = $this->db->prepare("UPDATE {$this->table} SET {$setClause} WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        return $stmt->execute();
    }

    /**
     * Eliminar un registro (con validación de ID)
     */
    public function delete($id) 
    {
        // Sanitizar y validar ID
        $id = sanitize_int($id, 1);
        if ($id === false) {
            throw new Exception('ID inválido para eliminación');
        }
        
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Contar registros
     */
    public function count() 
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    /**
     * Buscar por campo específico (SEGURO)
     */
    public function findBy($field, $value, $limit = null) 
    {
        // Sanitizar nombre del campo
        $field = $this->sanitizeTableName($field);
        
        $query = "SELECT * FROM {$this->table} WHERE `{$field}` = :value";
        
        if ($limit !== null) {
            $limit = sanitize_int($limit, 1, 1000);
            if ($limit !== false) {
                $query .= " LIMIT {$limit}";
            }
        }
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        
        return $limit === 1 ? $stmt->fetch() : $stmt->fetchAll();
    }
    
    /**
     * Ejecutar consulta personalizada SEGURA
     */
    public function executeSecureQuery($query, $params = []) 
    {
        // Verificar que la consulta no sea peligrosa
        if (detect_sql_injection($query)) {
            throw new Exception('Consulta SQL inválida detectada');
        }
        
        $stmt = $this->db->prepare($query);
        
        // Bind parameters de forma segura
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        
        $stmt->execute();
        return $stmt;
    }
    
    /**
     * Buscar con condiciones múltiples SEGURAS
     */
    public function findWhere($conditions = [], $limit = null, $offset = null) 
    {
        if (empty($conditions)) {
            return $this->findAll();
        }
        
        $where_clauses = [];
        $params = [];
        
        foreach ($conditions as $field => $value) {
            // Sanitizar nombre del campo
            $field = $this->sanitizeTableName($field);
            $placeholder = ':' . $field;
            
            $where_clauses[] = "`{$field}` = {$placeholder}";
            $params[$placeholder] = $value;
        }
        
        $query = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $where_clauses);
        
        // Agregar LIMIT si se especifica
        if ($limit !== null) {
            $limit = sanitize_int($limit, 1, 1000);
            if ($limit !== false) {
                $query .= " LIMIT {$limit}";
                
                if ($offset !== null) {
                    $offset = sanitize_int($offset, 0);
                    if ($offset !== false) {
                        $query .= " OFFSET {$offset}";
                    }
                }
            }
        }
        
        $stmt = $this->db->prepare($query);
        
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Verificar si existe un registro
     */
    public function exists($field, $value) 
    {
        $field = $this->sanitizeTableName($field);
        
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE `{$field}` = :value");
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
}
