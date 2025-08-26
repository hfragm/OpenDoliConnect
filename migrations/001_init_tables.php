<?php
/**
 * Migration 001 - Création des tables de base
 */

defined('ABSPATH') || exit;

function odc_run_migration_001_init_tables() {
    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $charset_collate = $wpdb->get_charset_collate();

    $table_jobs = $wpdb->prefix . 'odc_jobs';
    $table_logs = $wpdb->prefix . 'odc_logs';
    $table_maps = $wpdb->prefix . 'odc_maps';
    $table_schedules = $wpdb->prefix . 'odc_schedules';

    $sql = [];

    // File d'attente (jobs)
    $sql[] = "CREATE TABLE `$table_jobs` (
      `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
      `type` VARCHAR(64) NOT NULL,
      `payload_json` LONGTEXT NULL,
      `attempts` INT UNSIGNED NOT NULL DEFAULT 0,
      `max_attempts` INT UNSIGNED NOT NULL DEFAULT 5,
      `locked_at` DATETIME NULL,
      `available_at` DATETIME NOT NULL,
      `dedupe_key` VARCHAR(191) NULL,
      `status` VARCHAR(32) NOT NULL DEFAULT 'queued',
      `created_at` DATETIME NOT NULL,
      `updated_at` DATETIME NULL,
      PRIMARY KEY (`id`),
      KEY `idx_status_available` (`status`, `available_at`),
      KEY `idx_locked_at` (`locked_at`),
      UNIQUE KEY `uniq_dedupe_key` (`dedupe_key`)
    ) $charset_collate;";

    // Logs
    $sql[] = "CREATE TABLE `$table_logs` (
      `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
      `channel` VARCHAR(64) NOT NULL DEFAULT 'odc',
      `level` VARCHAR(16) NOT NULL,
      `message` TEXT NOT NULL,
      `context_json` LONGTEXT NULL,
      `created_at` DATETIME NOT NULL,
      PRIMARY KEY (`id`),
      KEY `idx_level_created` (`level`, `created_at`),
      KEY `idx_channel_created` (`channel`, `created_at`)
    ) $charset_collate;";

    // Mapping WP <-> Dolibarr
    $sql[] = "CREATE TABLE `$table_maps` (
      `object_type` VARCHAR(32) NOT NULL,
      `wp_id` BIGINT UNSIGNED NOT NULL,
      `doli_id` BIGINT UNSIGNED NULL,
      `doli_ref` VARCHAR(191) NULL,
      `last_hash` VARCHAR(191) NULL,
      `updated_at` DATETIME NOT NULL,
      PRIMARY KEY (`object_type`, `wp_id`),
      KEY `idx_doli_ref` (`doli_ref`),
      KEY `idx_updated_at` (`updated_at`)
    ) $charset_collate;";

    // Schedules (miroir lecture)
    $sql[] = "CREATE TABLE `$table_schedules` (
      `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
      `wp_order_id` BIGINT UNSIGNED NOT NULL,
      `doli_invoice_id` BIGINT UNSIGNED NULL,
      `due_date` DATE NOT NULL,
      `amount` DECIMAL(18,6) NOT NULL,
      `status` VARCHAR(32) NOT NULL,
      `updated_at` DATETIME NOT NULL,
      PRIMARY KEY (`id`),
      KEY `idx_order_due` (`wp_order_id`, `due_date`),
      KEY `idx_status` (`status`)
    ) $charset_collate;";

    foreach ($sql as $statement) {
        dbDelta($statement);
    }
}
