<?php
if (!defined('ABSPATH')) {
    exit;
}

// Function to rollback plugin
function ppu_rollback_plugin() {
    if (!current_user_can('update_plugins') || !check_admin_referer('rollback_plugin')) {
        wp_die(__('Unauthorized access', 'preview-plugin-update'));
    }

    $plugin = isset($_GET['plugin']) ? sanitize_text_field($_GET['plugin']) : '';
    if (empty($plugin)) {
        wp_die(__('Invalid plugin.', 'preview-plugin-update'));
    }

    $backup_dir = WP_CONTENT_DIR . '/plugin-backups/' . dirname($plugin);
    $plugin_dir = WP_PLUGIN_DIR . '/' . dirname($plugin);

    if (file_exists($backup_dir)) {
        // Restore backup
        ppu_copy_directory($backup_dir, $plugin_dir);
        wp_redirect(admin_url('plugins.php?rollback_success=1'));
        exit;
    } else {
        wp_die(__('Backup not found.', 'preview-plugin-update'));
    }
}
add_action('admin_menu', function () {
    add_submenu_page(null, 'Rollback Plugin Update', 'Rollback Plugin Update', 'manage_options', 'rollback-plugin', 'ppu_rollback_plugin');
});
