<?php

if (!defined('ABSPATH')) {
    exit;
}

function ppu_admin_menu() {
    add_menu_page(
        'Preview Plugin Update',
        'Plugin Update',
        'manage_options',
        'ppu-settings',
        'ppu_settings_page',
        'dashicons-update',
        99
    );
}

add_action('admin_menu', 'ppu_admin_menu');

function ppu_settings_page() {
    wp_enqueue_style('ppu-style', plugin_dir_url(__FILE__) . '../assets/styles.css');
    wp_enqueue_script('ppu-script', plugin_dir_url(__FILE__) . '../assets/script.js', [], false, true);

    $license_key = get_option('ppu_license_key', '');
    $is_previewing = isset($_GET['ppu_preview_update']);
    $is_rollback = isset($_GET['ppu_rollback']);
    ?>

    <div class="wrap">
        <div class="ppu-container">
            <h2>Plugin Preview Update</h2>

            <?php if ($is_previewing): ?>
                <div class="notice-ppu warning">
                    <p>Preview mode enabled. Test the plugin update before finalizing.</p>
                </div>
            <?php endif; ?>

            <?php if ($is_rollback): ?>
                <div class="notice-ppu">
                    <p>Rollback successful! You have restored the previous plugin version.</p>
                </div>
            <?php endif; ?>

            <form method="post" action="options.php">
                <?php
                settings_fields('ppu_settings');
                do_settings_sections('ppu_settings');
                submit_button();
                ?>
            </form>

            <div class="ppu-preview-box">
                <h3>Update Preview</h3>
                <p>Before updating, preview the new version to test its functionality.</p>
                <button class="ppu-button ppu-preview-update">Preview Update</button>
            </div>

            <div class="ppu-preview-box">
                <h3>Rollback Option</h3>
                <p>If the update causes issues, rollback to the previous version.</p>
                <button class="ppu-button ppu-rollback-update" style="background: #d63638;">Rollback</button>
            </div>
        </div>
    </div>
    <?php
}

function ppu_register_settings() {
    register_setting('ppu_settings', 'ppu_license_key');
    add_settings_section('ppu_license_section', 'License Settings', null, 'ppu_settings');
    add_settings_field('ppu_license_key', 'License Key', 'ppu_license_key_field', 'ppu_settings', 'ppu_license_section');
}

add_action('admin_init', 'ppu_register_settings');

function ppu_license_key_field() {
    $license_key = get_option('ppu_license_key', '');
    echo '<input class="ppu-input" type="text" name="ppu_license_key" value="' . esc_attr($license_key) . '" />';
}
