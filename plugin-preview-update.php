<?php
/**
 * Plugin Name: Preview Plugin Update
 * Description: Allows admins to preview plugin updates before finalizing them.
 * Version: 1.0.0
 * Author: Amit
 * License: GPL-2.0+
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define('PPU_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PPU_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once PPU_PLUGIN_DIR . 'includes/admin-ui.php';
require_once PPU_PLUGIN_DIR . 'includes/updater.php';
require_once PPU_PLUGIN_DIR . 'includes/rollback.php';
require_once PPU_PLUGIN_DIR . 'includes/security.php';

// Enqueue admin scripts and styles
function ppu_enqueue_admin_assets() {
    wp_enqueue_style('ppu-admin-style', PPU_PLUGIN_URL . 'assets/css/admin-style.css');
    wp_enqueue_script('ppu-admin-script', PPU_PLUGIN_URL . 'assets/js/admin-script.js', ['jquery'], false, true);
}
add_action('admin_enqueue_scripts', 'ppu_enqueue_admin_assets');
