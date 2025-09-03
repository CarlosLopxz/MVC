# Leapcol MVC Framework

Framework MVC desarrollado por **Leapcol Software y Tecnología**

Un framework MVC simple, eficiente y profesional desarrollado en PHP con Bootstrap 5.

## Estructura del Proyecto

```
mvc/
├── app/
│   ├── controllers/           # Controladores de la aplicación
│   │   ├── BaseController.php # Controlador base
│   │   └── DashboardController.php # Controlador del dashboard
│   ├── models/               # Modelos de datos
│   │   └── BaseModel.php     # Modelo base
│   ├── views/                # Vistas de la aplicación
│   │   ├── dashboard/        # Vistas del dashboard
│   │   │   └── index.php     # Vista principal del dashboard
│   │   └── templates/        # Templates reutilizables
│   │       ├── header.php    # Header global con carga automática de CSS
│   │       └── footer.php    # Footer global con carga automática de JS
│   └── helpers/              # Funciones helper
│       └── functions.php     # Funciones útiles (base_url manual, assets_url, etc.)
├── assets/                   # Assets del framework (NUEVO)
│   ├── css/                  # Hojas de estilo
│   │   ├── app.css          # CSS global del framework
│   │   └── dashboard.css    # CSS específico del dashboard
│   ├── js/                   # JavaScript
│   │   ├── app.js           # JS global del framework
│   │   └── dashboard.js     # JS específico del dashboard
│   ├── images/               # Imágenes del framework
│   ├── fonts/                # Fuentes personalizadas
│   ├── scss/                 # Archivos SCSS (opcional)
│   └── plantillas/           # Templates adicionales
├── config/                   # Configuraciones
│   ├── app.php              # ⚠️ CONFIGURACIÓN PRINCIPAL (URLs manuales)
│   ├── database.php          # Configuración de la base de datos
│   └── Connection.php        # Clase de conexión a la BD
├── uploads/                  # Archivos subidos por usuarios (NUEVO)
├── vendor/                   # Dependencias externas (NUEVO)
├── public/                   # Archivos públicos adicionales
├── .htaccess                 # Configuración de URLs amigables
├── index.php                 # Punto de entrada principal
└── README.md                 # Este archivo
```

## Configuración

### Base de Datos
1. Edita el archivo `config/database.php` con tus credenciales:
```php
return [
    'host' => 'localhost',
    'dbname' => 'tu_base_de_datos',
    'username' => 'tu_usuario',
    'password' => 'tu_contraseña',
    // ...
];
```

### Servidor Web
- Asegúrate de que Apache tenga habilitado `mod_rewrite`
- El proyecto debe estar en una carpeta accesible por el servidor web

## Uso

### URLs
- Dashboard: `http://localhost/mvc/`
- Info del sistema: `http://localhost/mvc/dashboard/info`

### Crear un Controlador
```php
<?php
require_once 'BaseController.php';

class MiController extends BaseController 
{
    public function index() 
    {
        $data = ['mensaje' => 'Hola mundo'];
        $this->loadView('mi_vista/index', $data);
    }
}
```

### Crear un Modelo
```php
<?php
require_once 'BaseModel.php';

class MiModel extends BaseModel 
{
    protected $table = 'mi_tabla';
    
    // Métodos específicos del modelo...
}
```

### Crear una Vista
```php
<?php require_once __DIR__ . '/../templates/header.php'; ?>

<h1>Mi Vista</h1>
<p><?php echo escape($mensaje); ?></p>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
```

## Características

### Características Básicas
- ✅ Patrón MVC completo
- ✅ Routing automático
- ✅ Conexión a base de datos con PDO
- ✅ Templates reutilizables
- ✅ Funciones helper
- ✅ Autoloader automático
- ✅ URLs amigables

### Características Avanzadas (🆕 NUEVO)
- ✅ **Configuración manual de URLs** (base_url, assets_url, media_url)
- ✅ **Sistema de assets dinámico** - Carga automática de CSS/JS por controlador
- ✅ **Estructura de assets completa** (css, js, images, fonts, scss, plantillas)
- ✅ **JavaScript y CSS específico por controlador**
- ✅ **Framework JS integrado** con utilidades y manejo de errores
- ✅ **Sistema de notificaciones avanzado**
- ✅ **Diseño responsivo con Bootstrap 5**
- ✅ **Font Awesome integrado**
- ✅ **Animaciones CSS personalizadas**
- ✅ **Soporte para dark mode**
- ✅ **Seguridad mejorada** (XSS, CSRF, headers de seguridad)
- ✅ **Carpetas de uploads y vendor**

## Configuración de URLs (⚠️ IMPORTANTE)

### Configuración Manual de URLs (SIMPLIFICADA)
Solo edita `config/app.php` - **únicamente necesitas configurar base_url**:

```php
return [
    // ⚠️ SOLO CAMBIAR ESTA URL SEGÚN TU ENTORNO
    'base_url' => 'http://localhost/mvc/',
    // Las demás URLs se generan automáticamente:
    // assets_url = base_url + 'assets/'
    // media_url = base_url + 'uploads/'
];
```

### Funciones de URL Disponibles
```php
// URL base
echo base_url('dashboard'); // http://localhost/mvc/dashboard

// URL de assets (automática = base_url + assets/)
echo assets_url('css/app.css'); // http://localhost/mvc/assets/css/app.css

// URL de medios (automática = base_url + uploads/)
echo media_url('imagen.jpg'); // http://localhost/mvc/uploads/imagen.jpg
```

## Sistema de Assets Dinámico

### Carga Automática de CSS/JS
El framework carga automáticamente archivos específicos del controlador:

- `assets/css/dashboard.css` se carga automáticamente en DashboardController
- `assets/js/dashboard.js` se carga automáticamente en DashboardController
- `assets/css/usuario.css` se cargaría automáticamente en UsuarioController

### Estructura de Archivos por Controlador
```
assets/
├── css/
│   ├── app.css              # CSS global
│   ├── dashboard.css        # CSS del DashboardController
│   └── usuario.css          # CSS del UsuarioController
└── js/
    ├── app.js               # JS global
    ├── dashboard.js         # JS del DashboardController
    └── usuario.js           # JS del UsuarioController
```

## Requisitos

- PHP 7.4+
- MySQL/MariaDB
- Apache con mod_rewrite habilitado

## Tema Corporativo Leapcol

Este framework incluye un tema corporativo rojo minimalista que refleja la identidad de Leapcol Software y Tecnología:

### Colores Corporativos
- **Rojo principal**: `#dc3545`
- **Rojo oscuro**: `#b02a37`
- **Rojo claro**: `#f8d7da`

### Características del Tema
- ✅ Navbar con logo placeholder y branding corporativo
- ✅ Footer minimalista con información de la empresa
- ✅ Botones con estilo corporativo (`.btn-leapcol`)
- ✅ Iconos con colores corporativos (`.icon-leapcol`)
- ✅ Cards con bordes rojos distintivos
- ✅ Alerts personalizados con tema Leapcol

### Reemplazar Logo
Para agregar el logo de Leapcol:
1. Coloca el logo en `assets/images/leapcol-logo.png`
2. Sigue las instrucciones en `assets/images/LOGO_README.md`

---

## Autoría y Licencia

**Desarrollado por:** Leapcol Software y Tecnología
**Año:** 2025
**Versión:** 1.0.0
**Licencia:** MIT License

### Acerca de Leapcol
Leapcol Software y Tecnología es una empresa especializada en el desarrollo de software y soluciones tecnológicas innovadoras. Este framework MVC representa nuestro compromiso con la creación de herramientas de desarrollo eficientes y profesionales.

**Contacto y Soporte:**
- Para consultas sobre el framework o servicios de desarrollo
- Especialización en desarrollo de software personalizado
- Soluciones tecnológicas empresariales

---

*Framework desarrollado con ❤️ por Leapcol Software y Tecnología © 2025*
