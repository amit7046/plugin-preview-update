<?php
if (!defined('ABSPATH')) exit;

// Hook into plugin list actions
add_filter('plugin_action_links', 'ppu_add_preview_update_button', 10, 2);

function ppu_add_preview_update_button($actions, $plugin_file) {
    $preview_url = admin_url("admin.php?page=preview-update&plugin=" . urlencode($plugin_file));
    $actions['preview_update'] = '<a href="' . esc_url($preview_url) . '" class="ppu-preview-button">Preview Update</a>';
    return $actions;
}

// Load CSS & JS
add_action('admin_enqueue_scripts', 'ppu_enqueue_admin_scripts');
function ppu_enqueue_admin_scripts() {
    wp_enqueue_style('ppu-admin-style', plugin_dir_url(__FILE__) . '../assets/css/admin-style.css');
    wp_enqueue_script('ppu-admin-script', plugin_dir_url(__FILE__) . '../assets/js/admin-script.js', ['jquery'], null, true);
}
