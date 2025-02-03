<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete plugin options
delete_option('ppu_active');

// Remove transient data if any
delete_transient('ppu_preview_update');

// Clean up backup directories if needed
$backup_dir = WP_PLUGIN_DIR . '/backup_';
$files = glob($backup_dir . '*', GLOB_ONLYDIR);
foreach ($files as $file) {
    if (is_dir($file)) {
        // Use WordPress function to delete directories safely
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            WP_Filesystem();
        }
        $wp_filesystem->rmdir($file, true);
    }
}
