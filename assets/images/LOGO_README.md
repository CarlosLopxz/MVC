# Logo de Leapcol Software y Tecnología

## Instrucciones para agregar el logo

1. **Coloca el logo de Leapcol** en esta carpeta con el nombre `leapcol-logo.png`

2. **Tamaño recomendado**: 120px x 40px (para que encaje perfectamente en la navbar)

3. **Formato**: PNG con fondo transparente preferible

4. **Actualizar el header**: 
   - Abre `app/views/templates/header.php`
   - Busca la línea que dice `<div class="logo-placeholder me-2">LOGO</div>`
   - Reemplázala con:
   ```php
   <img src="<?php echo assets_url('images/leapcol-logo.png'); ?>" 
        alt="Leapcol Software y Tecnología" 
        height="40" 
        class="me-2">
   ```

## Ubicación actual del placeholder

El placeholder se encuentra en:
- **Navbar**: `app/views/templates/header.php` línea ~31
- **Clase CSS**: `.logo-placeholder` en `assets/css/leapcol.css`

## Ejemplo de reemplazo completo:

```php
<!-- ANTES (placeholder) -->
<div class="logo-placeholder me-2">LOGO</div>

<!-- DESPUÉS (logo real) -->
<img src="<?php echo assets_url('images/leapcol-logo.png'); ?>" 
     alt="Leapcol Software y Tecnología" 
     height="40" 
     class="me-2">
```

## Colores corporativos de Leapcol

- **Rojo principal**: #dc3545
- **Rojo oscuro**: #b02a37  
- **Rojo claro**: #f8d7da

Estos colores ya están implementados en el tema del framework.
