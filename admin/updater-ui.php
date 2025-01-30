<?php
if (!defined('ABSPATH')) {
    exit;
}

function ppu_render_update_preview() {
    ?>
    <div class="wrap">
        <h2>Plugin Update Preview</h2>
        <div class="ppu-preview-box">
            <p>This is a test mode for previewing the latest plugin update.</p>
            <button class="ppu-button ppu-finalize-update">Finalize Update</button>
            <button class="ppu-button ppu-rollback-update" style="background: #d63638;">Rollback</button>
        </div>
    </div>
    <?php
}
?>
