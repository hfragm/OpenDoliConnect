<?php
/**
 * Migration 002 - Indexes et contraintes additionnels
 */

defined('ABSPATH') || exit;

function odc_run_migration_002_add_indexes() {
    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $charset_collate = $wpdb->get_charset_collate();

    $table_maps = $wpdb->prefix . 'odc_maps';

    $sql = "CREATE TABLE `$table_maps` (
      `object_type` VARCHAR(32) NOT NULL,
      `wp_id` BIGINT UNSIGNED NOT NULL,
      `doli_id` BIGINT UNSIGNED NULL,
      `doli_ref` VARCHAR(191) NULL,
      `last_hash` VARCHAR(191) NULL,
      `updated_at` DATETIME NOT NULL,
      PRIMARY KEY (`object_type`, `wp_id`),
      KEY `idx_doli_ref` (`doli_ref`),
      KEY `idx_updated_at` (`updated_at`),
      UNIQUE KEY `uniq_object_doli` (`object_type`, `doli_id`)
    ) $charset_collate;";

    dbDelta($sql);
}
