document.addEventListener("DOMContentLoaded", function () {
    let previewBtn = document.querySelector(".ppu-preview-update");
    let rollbackBtn = document.querySelector(".ppu-rollback-update");

    if (previewBtn) {
        previewBtn.addEventListener("click", function () {
            if (confirm("Are you sure you want to preview this update?")) {
                window.location.href = window.location.href + "&ppu_preview_update=true";
            }
        });
    }

    if (rollbackBtn) {
        rollbackBtn.addEventListener("click", function () {
            if (confirm("Are you sure you want to rollback to the previous version?")) {
                window.location.href = window.location.href + "&ppu_rollback=true";
            }
        });
    }
});
