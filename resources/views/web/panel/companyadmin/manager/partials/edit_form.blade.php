<form action="{{ route('admin.manager.update', $manager->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
    @csrf
    @method('PUT')

    <div class="text-center mb-3">
        <input type="file" name="logo" id="editLogoInput" class="d-none" accept="image/*" onchange="previewEditLogo(event)">
        <label for="editLogoInput" style="cursor: pointer;">
            <img id="editLogoPreview"
                src="{{ $manager->logo ? asset('storage/' . $manager->logo) : 'https://med.gov.bz/wp-content/uploads/2020/08/dummy-profile-pic.jpg' }}"
                class="rounded-circle border"
                style="width: 100px; height: 100px; object-fit: cover;">
            <div class="small text-muted mt-1">Click to change logo</div>
        </label>
    </div>

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ $manager->name }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $manager->email }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ $manager->description }}</textarea>
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
