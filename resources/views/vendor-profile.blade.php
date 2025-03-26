@extends('layouts.vendorlayout')

@section('title', 'Vendor Profile')

@section('content')
<main class="main-content bgc-grey-100">
    <div id="mainContent">
        <div class="row gap-20 masonry pos-r">
            <div class="masonry-sizer col-md-6"></div>
            <div class="masonry-item col-md-6">
                <div class="bgc-white p-20 bd">
                    <h6 class="c-grey-900">Vendor Profile</h6>
                    <div class="mT-30">
                        @if(isset($vendor) && $vendor)
                            <!-- Display the vendor profile -->
                            <div>
                                <p><strong>Business Name:</strong> {{ $vendor->business_name }}</p>
                                <p><strong>Description:</strong> {{ $vendor->description }}</p>
                                <p><strong>Location:</strong> {{ $vendor->location }}</p>
                                <p><strong>Contact:</strong> {{ $vendor->contact }}</p>
                                <a href="{{ route('vendor.profile.storeOrUpdate') }}" class="btn btn-primary">Edit Profile</a>
                            </div>
                        @else
                            <!-- Show form to create the vendor profile -->
                            <form method="POST" action="{{ route('vendor.profile.storeOrUpdate') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="business_name" class="form-label">Business Name</label>
                                    <input type="text" class="form-control" id="business_name" name="business_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" required>
                                </div>
                                <div class="mb-3">
                                    <label for="contact" class="form-label">Contact</label>
                                    <input type="text" class="form-control" id="contact" name="contact" required>
                                </div>
                                <button type="submit" class="btn btn-success">Create Profile</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection