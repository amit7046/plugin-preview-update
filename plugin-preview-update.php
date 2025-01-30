<?php
/**
 * Plugin Name: Preview Plugin Update
 * Plugin URI: https://yourwebsite.com/
 * Description: Allows admin to preview plugin updates before applying them permanently.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com/
 * License: GPL-2.0+
 * Text Domain: plugin-preview-update
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define constants
define('PPU_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PPU_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PPU_PLUGIN_VERSION', '1.0.0');
define('PPU_LICENSE_SERVER', 'https://yourserver.com/api/');

// Include necessary files
require_once PPU_PLUGIN_DIR . 'includes/class-plugin-updater.php';
require_once PPU_PLUGIN_DIR . 'includes/license-handler.php';
require_once PPU_PLUGIN_DIR . 'includes/security.php';

// Initialize Updater
if (is_admin()) {
    $license_key = get_option('ppu_license_key', '');
    $plugin_slug = plugin_basename(__FILE__);
    new Plugin_Updater($plugin_slug, PPU_PLUGIN_VERSION, PPU_LICENSE_SERVER, $license_key);
}

// Include admin settings
if (is_admin()) {
    require_once PPU_PLUGIN_DIR . 'admin/settings-page.php';
}
