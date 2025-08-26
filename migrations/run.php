<?php
/**
 * Exécuteur de migrations OpenDoliConnect
 * À appeler depuis register_activation_hook.
 */

defined('ABSPATH') || exit;

function odc_run_all_migrations() {
    if (!function_exists('dbDelta')) {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    }
    if (function_exists('odc_run_migration_001_init_tables')) {
        odc_run_migration_001_init_tables();
    } else {
        require __DIR__ . '/001_init_tables.php';
        odc_run_migration_001_init_tables();
    }

    if (function_exists('odc_run_migration_002_add_indexes')) {
        odc_run_migration_002_add_indexes();
    } else {
        require __DIR__ . '/002_add_indexes.php';
        odc_run_migration_002_add_indexes();
    }

    if (function_exists('odc_run_migration_003_seed_capabilities')) {
        odc_run_migration_003_seed_capabilities();
    } else {
        require __DIR__ . '/003_seed_capabilities.php';
        odc_run_migration_003_seed_capabilities();
    }
}
