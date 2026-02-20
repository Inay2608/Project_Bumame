<?php
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile) && is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line !== '' && strpos($line, '#') !== 0 && strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            putenv(trim($key) . '=' . trim($value, " \t\"'"));
        }
    }
}
$vendorAutoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($vendorAutoload)) {
    require_once $vendorAutoload;
}
$fileHelper = __DIR__ . '/../helpers/file_helper.php';
if (file_exists($fileHelper)) {
    require_once $fileHelper;
}
spl_autoload_register(function ($class) {
    // Base directory (assuming this file is in config/, so project root is ../)
    $baseDir = __DIR__ . '/../';

    // Map specific classes or patterns
    if ($class === 'Database') {
        $file = $baseDir . 'config/database.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // Check Controllers
    if (strpos($class, 'Controller') !== false) {
        $file = $baseDir . 'controllers/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // Check Models
    $file = $baseDir . 'models/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }

    // Check Helpers
    $file = $baseDir . 'helpers/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }
});
