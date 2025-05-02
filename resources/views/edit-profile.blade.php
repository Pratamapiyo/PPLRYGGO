@extends('layouts.layout')

@section('title', 'Edit Profile')

@section('content')
<section class="profile-section section-padding" id="section_4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12 mb-4">
                <div class="card card-custom shadow-sm border-1">
                    <div class="p-3 text-white rounded-top">
                        <h5 class="mb-0">Edit Profile</h5>
                    </div>
                    <div class="card-body p-5">
                        <div class="row d-flex align-items-center">
                            <div class="col-lg-6 col-12">
                                <form class="custom-form mt-3" action="{{ route('profile.uploadPicture') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="image-box mb-3" style="text-align: center;">
                                        <img id="profilePicturePreview"
                                            src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('assets/images/avatar/blankuser.png') }}"
                                            alt="Profile Picture"
                                            class="img-fluid rounded-circle"
                                            style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>
                                    <div class="mb-3 align-items-center">
                                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('profilePictureInput').click()" style="height: auto; margin-bottom: 10px;">Choose File</button>
                                        <input type="file" name="profile_picture" id="profilePictureInput" class="form-control d-none" accept="image/*" onchange="updateFileName(event)">
                                        <input type="text" id="fileNameDisplay" class="form-control" placeholder="No file chosen" readonly style="flex: 1; height: auto;">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Save Picture</button>
                                </form>
                            </div>

                            <div class="col-lg-6 col-12">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                
                                <form id="profileUpdateForm" class="custom-form" action="{{ route('profile.update') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="region" class="form-label">Region (Asal Daerah)</label>
                                        <input type="text" name="region" id="region" class="form-control" value="{{ old('region', Auth::user()->region) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep current password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Required to update password">
                                    </div>
                                    <button type="button" class="btn btn-primary" id="updateProfileBtn">Save Changes</button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Account Deletion Section -->
                        <div class="row mt-5">
                            <div class="col-12">
                                <hr class="my-4">
                                <h5 class="text-danger">Danger Zone</h5>
                                <div class="card border-danger mt-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title mb-1">Delete Account</h6>
                                                <p class="card-text text-muted small">Once you delete your account, there is no going back. Please be certain.</p>
                                            </div>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                                Delete Account
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Password Confirmation Modal -->
<div class="modal fade" id="passwordConfirmModal" tabindex="-1" aria-labelledby="passwordConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordConfirmModalLabel">Confirm Profile Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalErrorAlert" class="alert alert-danger" style="display: none;">
                    <strong>Error:</strong> <span id="errorMessage">The current password is incorrect.</span>
                </div>
                
                <p>Are you sure you want to update your profile information?</p>
                <div id="passwordUpdateWarning" class="alert alert-warning mt-3" style="display: none;">
                    <strong>Note:</strong> Your password will also be updated.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmProfileUpdate">Confirm Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Confirmation Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="deleteAccountModalLabel">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <strong>Warning:</strong> This action cannot be undone. This will permanently delete your account, all data, and remove your access to the system.
                </div>
                
                <p>Please type <strong>"saya ingin tutup akun ini"</strong> to confirm.</p>
                
                <form id="deleteAccountForm" action="{{ route('account.deactivate') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <input type="text" id="confirmationText" name="confirmation_text" class="form-control" placeholder="Type confirmation text here" autocomplete="off">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn" disabled>Delete Account</button>
            </div>
        </div>
    </div>
</div>

<script>
    function updateFileName(event) {
        const fileInput = event.target;
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        fileNameDisplay.value = fileInput.files.length > 0 ? fileInput.files[0].name : 'No file chosen';

        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profilePicturePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(fileInput.files[0]);
    }

    // Password confirmation modal logic
    document.getElementById('updateProfileBtn').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const currentPasswordField = document.getElementById('current_password');
        const warningElement = document.getElementById('passwordUpdateWarning');
        const errorAlert = document.getElementById('modalErrorAlert');
        
        // Reset error display
        errorAlert.style.display = 'none';
        
        // Check if user is updating password
        const isUpdatingPassword = passwordField.value.trim() !== '';
        
        if (isUpdatingPassword) {
            // If updating password, check that current password is provided
            warningElement.style.display = 'block';
            
            if (currentPasswordField.value.trim() === '') {
                // Show error if current password missing when updating password
                errorAlert.style.display = 'block';
                document.getElementById('errorMessage').textContent = 'Please enter your current password to update your password.';
                return;
            }
        } else {
            // Not updating password, hide the password warning
            warningElement.style.display = 'none';
            
            // For non-password updates, no need for current password
            // Just show the confirmation modal
        }

        // Show confirmation modal
        const modal = new bootstrap.Modal(document.getElementById('passwordConfirmModal'));
        modal.show();
    });

    document.getElementById('confirmProfileUpdate').addEventListener('click', function() {
        // Submit the form directly
        document.getElementById('profileUpdateForm').submit();
    });
    
    // Handle password errors with inline notification instead of alert
    @if ($errors->has('current_password'))
        document.addEventListener('DOMContentLoaded', function() {
            // Create an error notification at the top of the form
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger alert-dismissible fade show';
            errorDiv.innerHTML = `
                <strong>Error:</strong> {{ $errors->first('current_password') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            // Insert at the beginning of the form
            const form = document.getElementById('profileUpdateForm');
            form.insertBefore(errorDiv, form.firstChild);
            
            // Focus back on the current password field
            document.getElementById('current_password').focus();
        });
    @endif
    
    // Handle success messages with inline notification instead of alert
    @if (session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            // Create a success notification that appears within the form
            const successDiv = document.createElement('div');
            successDiv.className = 'alert alert-success alert-dismissible fade show';
            successDiv.innerHTML = `
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            // Insert at the beginning of the form
            const form = document.getElementById('profileUpdateForm');
            form.insertBefore(successDiv, form.firstChild);
        });
    @endif

    // Account deletion confirmation
    document.getElementById('confirmationText').addEventListener('input', function() {
        const requiredText = "saya ingin tutup akun ini";
        const confirmButton = document.getElementById('confirmDeleteBtn');
        
        if (this.value.toLowerCase() === requiredText) {
            confirmButton.disabled = false;
        } else {
            confirmButton.disabled = true;
        }
    });
    
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        document.getElementById('deleteAccountForm').submit();
    });
</script>
@endsection