<?php
if (!defined('ABSPATH')) {
    exit;
}

// Disable direct access to plugin files
function ppu_block_direct_access() {
    if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
        die(__('Access denied.', 'preview-plugin-update'));
    }
}
add_action('init', 'ppu_block_direct_access');
