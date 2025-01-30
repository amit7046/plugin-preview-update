<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Remove stored settings and license key
delete_option('ppu_license_key');
delete_option('ppu_plugin_version');
?>
