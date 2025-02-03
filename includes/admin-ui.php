<?php
if (!defined('ABSPATH')) {
    exit;
}

// Add "Preview Update" button in plugin list
function ppu_add_preview_update_link($actions, $plugin_file, $plugin_data, $context) {
    if (isset($actions['upgrade'])) {
        $preview_url = wp_nonce_url(admin_url('admin.php?page=preview-update&plugin=' . urlencode($plugin_file)), 'preview_update');
        $actions['preview_update'] = '<a href="' . esc_url($preview_url) . '" style="color: blue; font-weight: bold;">Preview Update</a>';
    }
    return $actions;
}
add_filter('plugin_action_links', 'ppu_add_preview_update_link', 10, 4);
