<?php
namespace ODC\Infrastructure\WP;

class AdminMenu {
    public static function register() {
        add_action('admin_menu', function() {
            add_menu_page(
                'OpenDoliConnect',
                'OpenDoliConnect',
                'manage_options',
                'opendoliconnect',
                [self::class, 'renderDashboard'],
                'dashicons-randomize'
            );
        });
    }

    public static function renderDashboard() {
        echo '<div class="wrap"><h1>OpenDoliConnect</h1><p>Bienvenue dans le connecteur WooCommerce ↔ Dolibarr.</p></div>';
    }
}
