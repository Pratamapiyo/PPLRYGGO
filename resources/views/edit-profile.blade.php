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
                                <form class="custom-form" action="{{ route('profile.update') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="region" class="form-label">Region (Asal Daerah)</label>
                                        <input type="text" name="region" id="region" class="form-control" value="{{ Auth::user()->region }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep current password">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
</script>
@endsection