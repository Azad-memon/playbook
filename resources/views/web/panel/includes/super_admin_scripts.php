<script>
    function manageUsers() {
        // dataUrl = "<?//= route('superadmin.users.manage') ?>";
        dataUrl = null;
        $.ajax({
            url: dataUrl,
            success: function (data) {
                $('#manage-users').html(data);
            }
        })
    }



    $(document).on("click", "#add-user", async function (event) {
        $("#custom-modal-title").text("Add Officer");

        // var data_url = "<?//= route('superadmin.users.manage.add') ?>";
        var data_url = null;
        $.ajax({
            url: data_url,
            success: function (data) {
                $(".custom-modal").modal("show");
                $("#custom-modal-body").html(data);
            }
        })
    });

    $(document).on('submit', '#add-user-form', async function (e) {
        e.preventDefault();
        var submit_button_text = $("#custom-save-button").html();

        var form_data = new FormData(this);
        // var form_url = "<? //= route('superadmin.users.manage.save') ?>";
        var form_url = null;
        const isSuccess = await saveFormDataAjax(form_data, form_url, submit_button_text);
        if (isSuccess == true) {
            manageUsers();
        }
    })

 $(document).on("click", "[data-open-modal]", async function (event) {
    event.preventDefault();

    let title = $(this).data("modal-title") || "Modal";
    let url = $(this).data("url"); // Will be passed from Blade with route()

    $("#custom_modal_title").text(title);
    $(".custom_modal").modal("show");
console.log('heree'+ url);
    if (url) {
        try {
            let response = await $.get(url);
            $("#custom_modal_body").html(response);
        } catch (err) {
            $("#custom_modal_body").html("<p class='text-danger'>Failed to load content.</p>");
        }
    }
});
function previewLogo(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('logoPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}



</script>
