jQuery(document).ready(function($) {
    $(".ppu-preview-button").click(function(e) {
        e.preventDefault();
        if (confirm("Are you sure you want to preview this update?")) {
            window.location.href = $(this).attr("href");
        }
    });
});
