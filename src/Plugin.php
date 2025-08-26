<?php
namespace ODC;

use ODC\Infrastructure\WP\AdminMenu;
use ODC\Infrastructure\WP\Settings;

class Plugin {
    public static function boot() {
        // Init plugin services
        add_action('init', [self::class, 'init']);
        AdminMenu::register();
        Settings::register();
    }

    public static function init() {
        // Hooks init (future sync, CRON, REST)
    }
}
