<form action="{{ route('superadmin.company.update', $company->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
    @csrf
    @method('PUT')

    <div class="text-center mb-3">
        <input type="file" name="logo" id="editLogoInput" class="d-none" accept="image/*" onchange="previewEditLogo(event)">
        <label for="editLogoInput" style="cursor: pointer;">
            <img id="editLogoPreview"
                src="{{ $company->logo ? asset('storage/' . $company->logo) : 'https://med.gov.bz/wp-content/uploads/2020/08/dummy-profile-pic.jpg' }}"
                class="rounded-circle border"
                style="width: 100px; height: 100px; object-fit: cover;">
            <div class="small text-muted mt-1">Click to change logo</div>
        </label>
    </div>

    <div class="mb-3">
        <label class="form-label">Company Name</label>
        <input type="text" name="name" class="form-control" value="{{ $company->name }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Company Email</label>
        <input type="email" name="company_email" class="form-control" value="{{ $company->email }}" required>
    </div>

    {{-- <div class="mb-3">
        <label class="form-label">Admin Email</label>
        <input type="email" name="admin_email" class="form-control" value="{{ $company->admin_email }}" required>
    </div> --}}

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ $company->description }}</textarea>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="editBtn">Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>

<script>
    function previewEditLogo(event) {
        const reader = new FileReader();
        reader.onload = function(){
            document.getElementById('editLogoPreview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    const editForm = document.getElementById("editForm");
    const editBtn = document.getElementById("editBtn");

    editForm.addEventListener("submit", function() {
        editBtn.disabled = true;
        editBtn.innerHTML = 'Updating...';
    });
</script>
