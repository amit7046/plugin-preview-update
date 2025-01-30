<?php
if (!defined('ABSPATH')) {
    exit;
}

class PPU_Rollback {
    public static function rollback_plugin() {
        $backup_path = WP_CONTENT_DIR . '/backup-plugin-preview-update.zip';

        if (!file_exists($backup_path)) {
            wp_die(__('No backup found to restore.', 'ppu'));
        }

        // Unzip and replace current plugin files
        $zip = new ZipArchive;
        if ($zip->open($backup_path) === TRUE) {
            $zip->extractTo(plugin_dir_path(__DIR__));
            $zip->close();
            unlink($backup_path);
            wp_redirect(admin_url('admin.php?page=ppu-settings&ppu_rollback=true'));
            exit;
        } else {
            wp_die(__('Failed to restore backup.', 'ppu'));
        }
    }
}

if (isset($_GET['ppu_rollback'])) {
    PPU_Rollback::rollback_plugin();
}
?>
