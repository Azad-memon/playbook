<form action="{{ route('admin.employee.store') }}" method="POST" enctype="multipart/form-data" id="createManagerForm">
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
        <label class="form-label">Employee Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <input type="hidden" name="company_id" value="{{$company_id}}">
    <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="createManagerBtn">Create</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>

<script>
   const form = document.getElementById("createManagerForm");
    const createBtn = document.getElementById("createManagerBtn");

    form.addEventListener("submit", function() {
        createBtn.disabled = true;
        createBtn.innerHTML = 'Processing...';
    });
</script>

