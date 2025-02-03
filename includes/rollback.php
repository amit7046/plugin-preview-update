<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', function() {
    add_submenu_page('tools.php', 'Rollback Plugin Update', 'Rollback Update', 'manage_options', 'rollback-update', 'ppu_rollback_update_page');
});

function ppu_rollback_update_page() {
    if (!current_user_can('manage_options')) return;

    $plugin_file = isset($_GET['plugin']) ? sanitize_text_field($_GET['plugin']) : '';
    if (!$plugin_file) {
        echo '<div class="error"><p>No plugin specified.</p></div>';
        return;
    }

    $plugin_dir = WP_PLUGIN_DIR . '/' . dirname($plugin_file);
    $backup_dir = WP_PLUGIN_DIR . '/backup_' . basename($plugin_dir);

    if (file_exists($backup_dir)) {
        copy_dir($backup_dir, $plugin_dir);
        echo '<div class="updated"><p>Plugin rollback successful.</p></div>';
    } else {
        echo '<div class="error"><p>Backup not found.</p></div>';
    }
}
