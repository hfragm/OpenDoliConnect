<?php
namespace ODC\Infrastructure\WP;

class Settings {
    public static function register() {
        add_action('admin_init', function() {
            register_setting('odc_settings', 'odc_api_url');
            register_setting('odc_settings', 'odc_api_token');

            add_settings_section('odc_main', 'Connexion Dolibarr', null, 'opendoliconnect');

            add_settings_field('odc_api_url', 'URL API Dolibarr', function() {
                $value = esc_attr(get_option('odc_api_url'));
                echo '<input type="text" name="odc_api_url" value="' . $value . '" size="50" />';
            }, 'opendoliconnect', 'odc_main');

            add_settings_field('odc_api_token', 'Token API Dolibarr', function() {
                $value = esc_attr(get_option('odc_api_token'));
                echo '<input type="password" name="odc_api_token" value="' . $value . '" size="50" />';
            }, 'opendoliconnect', 'odc_main');
        });
    }

    public static function renderSettingsPage() {
        echo '<div class="wrap"><h1>Paramètres OpenDoliConnect</h1>';
        echo '<form method="post" action="options.php">';
        settings_fields('odc_settings');
        do_settings_sections('opendoliconnect');
        submit_button();
        echo '</form></div>';
    }
}
