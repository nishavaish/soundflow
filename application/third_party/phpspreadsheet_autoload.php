<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PSR Simple Cache interface (required by PhpSpreadsheet)
 */
require_once APPPATH . 'third_party/psr_simple_cache.php';


spl_autoload_register(function ($class) {
    $prefix = 'PhpOffice\\PhpSpreadsheet\\';
    $base_dir = APPPATH . 'third_party/PhpSpreadsheet/src/PhpSpreadsheet/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
