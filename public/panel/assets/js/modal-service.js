window.ModalService = {
    open: function (title, url) {
        $("#custom_modal_title").text(title);
        $("#custom_modal_body").html('<div class="text-center p-3">Loading...</div>');
        $(".custom_modal").modal("show");

        $.ajax({
            url: url,
            method: "GET",
            success: function (response) {
                $("#custom_modal_body").html(response);
            },
            error: function () {
                $("#custom_modal_body").html('<div class="text-danger p-3">Error loading content.</div>');
            }
        });
    }
};
