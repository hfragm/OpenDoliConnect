<?php
/**
 * Bootstrap PHPUnit pour OpenDoliConnect
 */

// Charger l'autoloader Composer
require dirname(__DIR__) . '/vendor/autoload.php';

// Définir constantes WP de test si besoin
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}
