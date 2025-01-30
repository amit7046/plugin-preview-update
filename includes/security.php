<?php
if (!defined('ABSPATH')) {
    exit;
}

class PPU_Security {
    public static function check_plugin_integrity() {
        $plugin_file = plugin_dir_path(__DIR__) . 'plugin-preview-update.php';

        if (!file_exists($plugin_file)) {
            return false;
        }

        $content = file_get_contents($plugin_file);
        return strpos($content, 'ppu_verify_security') !== false;
    }

    public static function block_direct_access() {
        if (basename($_SERVER['PHP_SELF']) === 'plugin-editor.php') {
            wp_die(__('You are not allowed to edit this plugin.', 'ppu'));
        }
    }
}

add_action('admin_init', ['PPU_Security', 'block_direct_access']);
?>
