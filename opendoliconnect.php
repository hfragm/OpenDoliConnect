<?php
/*
Plugin Name: OpenDoliConnect
Description: Connecteur open-source entre WooCommerce et Dolibarr ERP/CRM (produits, clients, commandes, factures, expéditions, stocks + échéancier optionnel).
Version: 0.1.0
Author: Asgard Hosting & Helptech Informatique
License: GPLv3
Text Domain: opendoliconnect
Domain Path: /languages
*/

defined('ABSPATH') || exit;

/**
 * Constantes
 */
define('ODC_VERSION', '0.1.0');
define('ODC_MIN_PHP', '8.1');
define('ODC_PLUGIN_FILE', __FILE__);
define('ODC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ODC_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Garde-fou version PHP
 */
if (version_compare(PHP_VERSION, ODC_MIN_PHP, '<')) {
    add_action('admin_notices', function () {
        echo '<div class="notice notice-error"><p>';
        echo esc_html__('OpenDoliConnect nécessite PHP ', 'opendoliconnect') . esc_html(ODC_MIN_PHP);
        echo esc_html__(' ou supérieur. Plugin désactivé.', 'opendoliconnect');
        echo '</p></div>';
    });
    return;
}

/**
 * Autoload Composer (facultatif si vous utilisez PSR-4)
 */
$vendor = ODC_PLUGIN_DIR . 'vendor/autoload.php';
if (file_exists($vendor)) {
    require_once $vendor;
}

/**
 * Chargement i18n
 */
add_action('init', function () {
    load_plugin_textdomain('opendoliconnect', false, dirname(plugin_basename(__FILE__)) . '/languages/');
});

/**
 * Intervalle CRON personnalisé (toutes les 5 minutes)
 */
add_filter('cron_schedules', function ($schedules) {
    if (!isset($schedules['odc_five_minutes'])) {
        $schedules['odc_five_minutes'] = [
            'interval' => 5 * 60,
            'display'  => __('Toutes les 5 minutes (OpenDoliConnect)', 'opendoliconnect'),
        ];
    }
    return $schedules;
});

/**
 * Activation : migrations + planification CRON
 */
register_activation_hook(__FILE__, function () {
    // Migrations
    $runner = ODC_PLUGIN_DIR . 'migrations/run.php';
    if (file_exists($runner)) {
        require_once $runner;
        if (function_exists('odc_run_all_migrations')) {
            odc_run_all_migrations();
        }
    }

    // CRON : exécuteur de file d’attente
    if (!wp_next_scheduled('odc_run_queue')) {
        wp_schedule_event(time() + 60, 'odc_five_minutes', 'odc_run_queue');
    }
});

/**
 * Désactivation : nettoyage CRON
 */
register_deactivation_hook(__FILE__, function () {
    $timestamp = wp_next_scheduled('odc_run_queue');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'odc_run_queue');
    }
});

/**
 * Action CRON : exécution de la queue (placeholder)
 * Vous pourrez brancher ici votre JobRunner (src/Infrastructure/Queue/JobRunner.php)
 */
add_action('odc_run_queue', function () {
    /**
     * Exemple minimal (à remplacer par votre implémentation) :
     * - Récupérer quelques jobs en statut "queued" et disponibles
     * - Marquer comme "running", tenter l’exécution, gérer retry expo
     * - Logger
     */
    do_action('odc_queue_tick'); // Hook interne libre d’usage
});

/**
 * REST API : healthcheck
 */
add_action('rest_api_init', function () {
    register_rest_route('odc/v1', '/health', [
        'methods'             => 'GET',
        'permission_callback' => '__return_true',
        'callback'            => function () {
            return new WP_REST_Response([
                'ok'       => true,
                'version'  => ODC_VERSION,
                'time'     => current_time('mysql'),
                'site'     => get_bloginfo('name'),
            ], 200);
        },
    ]);
});

/**
 * Enqueue assets Admin
 */
add_action('admin_enqueue_scripts', function ($hook) {
    // Vous pouvez cibler uniquement vos pages admin : strpos($hook, 'opendoliconnect') !== false
    wp_enqueue_style('odc-admin', ODC_PLUGIN_URL . 'assets/admin/css/admin.css', [], ODC_VERSION);
    wp_enqueue_script('odc-admin', ODC_PLUGIN_URL . 'assets/admin/js/admin.js', ['jquery'], ODC_VERSION, true);
});

/**
 * Enqueue assets Public
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('odc-public', ODC_PLUGIN_URL . 'assets/public/css/public.css', [], ODC_VERSION);
    wp_enqueue_script('odc-public', ODC_PLUGIN_URL . 'assets/public/js/public.js', [], ODC_VERSION, true);
});

/**
 * Capacités / rôles : peuvent déjà être posées via migrations (003_seed_capabilities).
 * Ici on s’assure juste que les caps existent si les migrations ne sont pas passées.
 */
add_action('init', function () {
    if (function_exists('get_role')) {
        $admin = get_role('administrator');
        if ($admin && !$admin->has_cap('manage_opendoliconnect')) {
            $admin->add_cap('manage_opendoliconnect');
            $admin->add_cap('view_opendoliconnect_logs');
            $admin->add_cap('sync_opendoliconnect');
        }
        $shop_manager = get_role('shop_manager');
        if ($shop_manager && !$shop_manager->has_cap('sync_opendoliconnect')) {
            $shop_manager->add_cap('sync_opendoliconnect');
        }
    }
});

/**
 * Menus & pages Admin
 * - Dashboard
 * - Logs
 * - Queue
 * - Settings
 * Les templates correspondants sont chargés depuis /templates/admin/*.php
 */
add_action('admin_menu', function () {
    $cap = 'manage_opendoliconnect'; // défini via config/capabilities.php + migrations

    add_menu_page(
        __('OpenDoliConnect', 'opendoliconnect'),
        'OpenDoliConnect',
        $cap,
        'opendoliconnect',
        function () {
            $logs  = []; // Exemple : injectez vos données ici
            $jobs  = [];
            $tpl   = ODC_PLUGIN_DIR . 'templates/admin/dashboard.php';
            if (file_exists($tpl)) {
                require $tpl;
            } else {
                echo '<div class="wrap"><h1>OpenDoliConnect</h1><p>';
                esc_html_e('Bienvenue dans le connecteur WooCommerce ↔ Dolibarr.', 'opendoliconnect');
                echo '</p></div>';
            }
        },
        'dashicons-randomize',
        58
    );

    add_submenu_page(
        'opendoliconnect',
        __('Journaux', 'opendoliconnect'),
        __('Journaux', 'opendoliconnect'),
        $cap,
        'opendoliconnect-logs',
        function () {
            // Préparez $logs depuis la table wp_odc_logs
            $logs = [];
            $tpl  = ODC_PLUGIN_DIR . 'templates/admin/logs.php';
            file_exists($tpl) ? require $tpl : print '<div class="wrap"><h1>Logs</h1></div>';
        }
    );

    add_submenu_page(
        'opendoliconnect',
        __('File d’attente', 'opendoliconnect'),
        __('File d’attente', 'opendoliconnect'),
        $cap,
        'opendoliconnect-queue',
        function () {
            // Préparez $jobs depuis la table wp_odc_jobs
            $jobs = [];
            $tpl  = ODC_PLUGIN_DIR . 'templates/admin/queue.php';
            file_exists($tpl) ? require $tpl : print '<div class="wrap"><h1>Queue</h1></div>';
        }
    );

    add_submenu_page(
        'opendoliconnect',
        __('Paramètres', 'opendoliconnect'),
        __('Paramètres', 'opendoliconnect'),
        $cap,
        'opendoliconnect-settings',
        function () {
            $tpl = ODC_PLUGIN_DIR . 'templates/admin/settings.php';
            file_exists($tpl) ? require $tpl : print '<div class="wrap"><h1>Settings</h1></div>';
        }
    );
});

/**
 * Enregistrement basique des réglages (URL & token) si aucune classe Settings n’est encore branchée.
 * Si vous utilisez src/Infrastructure/WP/Settings.php, vous pouvez retirer cette section
 * et laisser la classe gérer les settings fields.
 */
add_action('admin_init', function () {
    // Groupe d’options
    register_setting('odc_settings', 'odc_api_url', ['type' => 'string', 'sanitize_callback' => 'esc_url_raw']);
    register_setting('odc_settings', 'odc_api_token', ['type' => 'string', 'sanitize_callback' => 'sanitize_text_field']);

    add_settings_section('odc_main', __('Connexion Dolibarr', 'opendoliconnect'), '__return_false', 'opendoliconnect');

    add_settings_field('odc_api_url', __('URL API Dolibarr', 'opendoliconnect'), function () {
        $value = esc_attr(get_option('odc_api_url', ''));
        echo '<input type="url" name="odc_api_url" value="' . $value . '" size="60" placeholder="https://doli.example.com/api/index.php" />';
    }, 'opendoliconnect', 'odc_main');

    add_settings_field('odc_api_token', __('Token API Dolibarr', 'opendoliconnect'), function () {
        $value = esc_attr(get_option('odc_api_token', ''));
        echo '<input type="password" name="odc_api_token" value="' . $value . '" size="60" />';
    }, 'opendoliconnect', 'odc_main');
});

/**
 * Boot optionnel d’un conteneur de services si vous avez la classe ODC\Plugin
 * (recommandé : PSR-4 src/Plugin.php)
 */
if (class_exists('\\ODC\\Plugin')) {
    add_action('plugins_loaded', ['\\ODC\\Plugin', 'boot']);
}
