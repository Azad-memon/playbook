@extends('web/panel/layout')

@section('body_container')
<div class="row">
    <div class="card p-4">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('manager.profile.update') }}" method="POST" enctype="multipart/form-data" id="editProfileForm">
            @csrf

            {{-- Logo --}}
            <div class="text-center mb-3">
                <input type="file" name="logo" id="logoInput" class="d-none" accept="image/*" onchange="previewLogo(event)">
                <label for="logoInput" style="cursor: pointer;">
                    <img id="logoPreview"
                        src="{{ $user->logo ? asset('storage/'.$user->logo) : 'https://med.gov.bz/wp-content/uploads/2020/08/dummy-profile-pic.jpg' }}"
                        class="rounded-circle border"
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <div class="small text-muted mt-1">Click to upload profile</div>
                </label>
                @error('logo')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Full Name --}}
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email (locked) --}}
            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" value="{{ $user->email }}" readonly onfocus="this.blur()">
            </div>

            {{-- Designation --}}
            <div class="mb-3">
                <label>Designation</label>
                <input type="text" name="designation" class="form-control" value="{{ old('designation', $user->designation) }}">
                @error('designation')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Department --}}
            <div class="mb-3">
                <label>Department</label>
                <input type="text" name="department" class="form-control" value="{{ old('department', $user->department) }}">
                @error('department')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Line Manager --}}
            <div class="mb-3">
                <label>Line Manager</label>
                <input type="text" name="line_manager" class="form-control" value="{{ old('line_manager', $user->line_manager) }}">
                @error('line_manager')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description', $user->description) }}</textarea>
                @error('description')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label>Password (leave blank to keep existing)</label>
                <input type="password" name="password" class="form-control">
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror

                <input type="password" name="password_confirmation" class="form-control mt-2" placeholder="Confirm Password">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" id="updateBtn">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function previewLogo(event) {
    const output = document.getElementById('logoPreview');
    output.src = URL.createObjectURL(event.target.files[0]);
}
const form = document.getElementById("editProfileForm");
const updateBtn = document.getElementById("updateBtn");
form.addEventListener("submit", function() {
    updateBtn.disabled = true;
    updateBtn.innerHTML = 'Processing...';
});
</script>
@endsection
