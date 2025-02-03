<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', function() {
    add_submenu_page('tools.php', 'Preview Plugin Update', 'Preview Update', 'manage_options', 'preview-update', 'ppu_preview_update_page');
});

function ppu_preview_update_page() {
    if (!current_user_can('manage_options')) return;

    $plugin_file = isset($_GET['plugin']) ? sanitize_text_field($_GET['plugin']) : '';
    if (!$plugin_file) {
        echo '<div class="error"><p>No plugin specified.</p></div>';
        return;
    }

    // Step 1: Backup the plugin
    $plugin_dir = WP_PLUGIN_DIR . '/' . dirname($plugin_file);
    $backup_dir = WP_PLUGIN_DIR . '/backup_' . basename($plugin_dir);
    if (!file_exists($backup_dir)) {
        copy_dir($plugin_dir, $backup_dir);
    }

    // Step 2: Update the plugin (simulating update)
    $update_success = ppu_simulate_update($plugin_file);

    echo '<div class="wrap"><h2>Preview Plugin Update</h2>';
    if ($update_success) {
        echo '<p>Plugin updated successfully in preview mode. Test your site before finalizing.</p>';
        echo '<a href="' . esc_url(admin_url('admin.php?page=rollback-update&plugin=' . urlencode($plugin_file))) . '" class="button">Rollback</a>';
        echo ' <a href="' . esc_url(admin_url('plugins.php')) . '" class="button button-primary">Finalize Update</a>';
    } else {
        echo '<div class="error"><p>Failed to update plugin.</p></div>';
    }
    echo '</div>';
}

function ppu_simulate_update($plugin_file) {
    // Mock update logic: In real implementation, fetch & extract the update
    return true;
}
