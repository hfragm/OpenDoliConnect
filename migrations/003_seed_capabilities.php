<?php
/**
 * Migration 003 - Attribution des capacités aux rôles
 */

defined('ABSPATH') || exit;

function odc_run_migration_003_seed_capabilities() {
    if (!function_exists('get_role')) {
        return;
    }
    $caps = [
        'manage_opendoliconnect',
        'view_opendoliconnect_logs',
        'sync_opendoliconnect',
    ];

    $roles = [
        'administrator' => ['manage_opendoliconnect', 'view_opendoliconnect_logs', 'sync_opendoliconnect'],
        'shop_manager'  => ['sync_opendoliconnect'],
    ];

    foreach ($roles as $role_name => $role_caps) {
        $role = get_role($role_name);
        if (!$role) continue;
        foreach ($role_caps as $cap) {
            if (!$role->has_cap($cap)) {
                $role->add_cap($cap);
            }
        }
    }
}
