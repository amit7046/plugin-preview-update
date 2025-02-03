<?php
if (!defined('ABSPATH')) {
    exit;
}

// Function to backup and temporarily update the plugin
function ppu_preview_update() {
    if (!current_user_can('update_plugins') || !check_admin_referer('preview_update')) {
        wp_die(__('Unauthorized access', 'preview-plugin-update'));
    }

    $plugin = isset($_GET['plugin']) ? sanitize_text_field($_GET['plugin']) : '';
    if (empty($plugin)) {
        wp_die(__('Invalid plugin.', 'preview-plugin-update'));
    }

    $plugin_dir = WP_PLUGIN_DIR . '/' . dirname($plugin);
    $backup_dir = WP_CONTENT_DIR . '/plugin-backups/' . dirname($plugin);

    // Ensure backup folder exists
    if (!file_exists($backup_dir)) {
        mkdir($backup_dir, 0755, true);
    }

    // Copy plugin to backup directory
    ppu_copy_directory($plugin_dir, $backup_dir);

    // Run update
    wp_redirect(admin_url('update.php?action=upgrade-plugin&plugin=' . $plugin));
    exit;
}
add_action('admin_menu', function () {
    add_submenu_page(null, 'Preview Plugin Update', 'Preview Plugin Update', 'manage_options', 'preview-update', 'ppu_preview_update');
});

// Function to copy directory
function ppu_copy_directory($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (($file = readdir($dir)) !== false) {
        if ($file !== '.' && $file !== '..') {
            if (is_dir($src . '/' . $file)) {
                ppu_copy_directory($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}
