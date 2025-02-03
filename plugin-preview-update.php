<?php
/**
 * Plugin Name: Preview Plugin Update
 * Description: Adds a preview update functionality before finalizing a plugin update.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

// Include files
require_once plugin_dir_path(__FILE__) . 'includes/admin-ui.php';
require_once plugin_dir_path(__FILE__) . 'includes/updater.php';
require_once plugin_dir_path(__FILE__) . 'includes/rollback.php';

// Register activation and deactivation hooks
register_activation_hook(__FILE__, 'ppu_activate');
register_deactivation_hook(__FILE__, 'ppu_deactivate');

function ppu_activate() {
    add_option('ppu_active', true);
}

function ppu_deactivate() {
    delete_option('ppu_active');
}
