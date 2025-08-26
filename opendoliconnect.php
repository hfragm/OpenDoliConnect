<?php
/*
Plugin Name: OpenDoliConnect
Description: Connecteur open-source entre WooCommerce et Dolibarr ERP/CRM.
Version: 0.1.0
Author: Asgard Hosting & Helptech Informatique
License: GPLv3
Text Domain: opendoliconnect
*/

defined('ABSPATH') || exit;

require_once __DIR__ . '/vendor/autoload.php';

// Boot plugin
add_action('plugins_loaded', function() {
    if (class_exists('ODC\\Plugin')) {
        ODC\Plugin::boot();
    }
});
