<style>
    .custom-image-uploader {
        width: 100px;
        height: 100px;
        border: 2px dashed #ddd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        transition: border-color 0.3s ease;
        cursor: pointer;
    }

    .custom-image-uploader:hover {
        border-color: #5dcb85;
    }

    .placeholder-text {
        color: #aaa;
        font-size: 14px;
        text-align: center;
        position: absolute;
    }

    .preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        display: none;
    }

    edit-icon,
    .cross-icon {
        position: absolute;
        background-color: rgba(255, 255, 255, 0.8);
        color: #555;
        border-radius: 50%;
        display: flex;
        /* Ensure flex display */
        align-items: center;
        /* Align items in the center vertically */
        justify-content: center;
        /* Align items in the center horizontally */
        padding: 5px;
        /* This gives padding inside the icons */
        cursor: pointer;
        font-size: 15px;
        width: 30px;
        /* Set fixed width */
        height: 30px;
        /* Set fixed height */
        display: none;
        /* Hidden by default */
        transition: color 0.3s ease;
    }

    .edit-icon:hover,
    .cross-icon:hover {
        color: #5dcb85;
    }

    .cross-icon {
        top: 0px;
    }

    input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .form-label {
        display: block;
        font-weight: bold;
        margin-bottom: 10px;
        text-align: center;
    }

    .edit-icon {
        display: none !important;
    }
</style>

<div class="col-md-12 d-flex justify-content-center">
    <div class="text-center">
        <label class="form-label">{{ $labelCaption }}</label>
        <div class="upload-container custom-image-uploader">
            <!-- Placeholder Text -->
            <span class="placeholder-text" style="display: {{ $defaultImage ? 'none' : 'block' }}">Click to
                {{ $labelCaption }}</span>

            <input type="file" class="upload-input" accept="image/*" name="{{ $name }}">

            <img src="{{ $defaultImage ?? '' }}" class="preview-image" alt="Preview Image"
                style="display: {{ $defaultImage ? 'block' : 'none' }}">

            <span class="edit-icon" style="display: {{ $defaultImage ? 'block' : 'none' }}">
                <i class="fas fa-edit"></i>
            </span>

            <span class="cross-icon" style="display: {{ $defaultImage ? 'block' : 'none' }}">
                <i class="fas fa-times"></i>
            </span>

            @if ($defaultImage)
                <input type="hidden" name="hidden_{{ $name }}" value="{{ $defaultImage }}">
            @endif
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.upload-container').forEach(container => {
        const uploadInput = container.querySelector('.upload-input');
        const imgElement = container.querySelector('.preview-image');
        const placeholderText = container.querySelector('.placeholder-text');
        const editIcon = container.querySelector('.edit-icon');
        const crossIcon = container.querySelector('.cross-icon');

        uploadInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgElement.src = e.target.result;
                    imgElement.style.display = 'block';
                    placeholderText.style.display = 'none';
                    editIcon.style.display = 'flex';
                    crossIcon.style.display = 'flex';
                };
                reader.readAsDataURL(file);
            }
        });

        editIcon.addEventListener('click', () => {
            uploadInput.click(); // Trigger file input click
        });

        crossIcon.addEventListener('click', () => {
            imgElement.style.display = 'none';
            placeholderText.style.display = 'block';
            editIcon.style.display = 'none';
            crossIcon.style.display = 'none';
            uploadInput.value = ''; // Reset the file input

            container.querySelector('[name="hidden_{{ $name }}"]').value = '';
        });
    });
</script>
