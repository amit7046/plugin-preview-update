<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete plugin backup folder
$backup_dir = WP_CONTENT_DIR . '/plugin-backups';
if (file_exists($backup_dir)) {
    array_map('unlink', glob("$backup_dir/*"));
    rmdir($backup_dir);
}
