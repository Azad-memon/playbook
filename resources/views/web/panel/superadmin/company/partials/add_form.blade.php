<form action="{{ route('superadmin.company.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
    @csrf
    <div class="text-center mb-3">
        <input type="file" name="logo" id="logoInput" class="d-none" accept="image/*" onchange="previewLogo(event)">
        <label for="logoInput" style="cursor: pointer;">
            <img id="logoPreview"
                src="https://med.gov.bz/wp-content/uploads/2020/08/dummy-profile-pic.jpg"
                class="rounded-circle border"
                style="width: 100px; height: 100px; object-fit: cover;">
            <div class="small text-muted mt-1">Click to upload logo</div>
        </label>
    </div>

    <div class="mb-3">
        <label class="form-label">Company Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Company Email</label>
        <input type="email" name="company_email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Admin Email</label>
        <input type="email" name="admin_email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="createBtn">Create</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>

<script>
   const form = document.getElementById("createForm");
    const createBtn = document.getElementById("createBtn");

    form.addEventListener("submit", function() {
        createBtn.disabled = true;
        createBtn.innerHTML = 'Processing...';
    });
</script>

