<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - <?= get_app_config()['app_name']; ?></title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        
        .error-container {
            background: #ffffff;
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: 300;
            color: #f1f1f1;
            margin-bottom: 1rem;
            letter-spacing: -0.1em;
        }
        
        .error-title {
            font-size: 1.8rem;
            font-weight: 300;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .error-message {
            color: #666;
            margin-bottom: 3rem;
            line-height: 1.6;
            font-weight: 300;
        }
        
        .error-details {
            background: #f9f9f9;
            padding: 1rem;
            margin: 2rem 0;
            border-radius: 4px;
            font-size: 0.9rem;
            color: #666;
            text-align: left;
            font-family: monospace;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 0 10px;
            border: 1px solid #ddd;
            background: #fff;
            color: #333;
            text-decoration: none;
            font-weight: 300;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .btn:hover {
            background: #f9f9f9;
        }
        
        .footer {
            margin-top: 3rem;
            font-size: 0.8rem;
            color: #ccc;
            font-weight: 300;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        
        <h1 class="error-title">
            <?= isset($error_title) ? escape($error_title) : 'Página No Encontrada'; ?>
        </h1>
        
        <p class="error-message">
            <?= isset($error_message) ? escape($error_message) : 'La página que buscas no existe'; ?>
        </p>
        
        <?php if (isset($error_details) && !empty($error_details)): ?>
        <div class="error-details">
            <?= escape($error_details); ?>
        </div>
        <?php endif; ?>
        
        <div>
            <a href="<?= base_url(); ?>" class="btn">
                Inicio
            </a>
            <button onclick="history.back()" class="btn">
                Regresar
            </button>
        </div>
        
        <div class="footer">
            <?= get_app_config()['company_name']; ?>
        </div>
    </div>
</body>
</html>