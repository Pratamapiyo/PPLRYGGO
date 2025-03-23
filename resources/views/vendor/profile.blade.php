@extends('layouts.layout')

@section('title', 'Vendor Profile')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Manage Vendor Profile</h2>
    <form action="{{ route('vendor.profile.storeOrUpdate') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="business_name" class="form-label">Business Name</label>
            <input type="text" name="business_name" id="business_name" class="form-control" value="{{ $vendor->business_name ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $vendor->description ?? '' }}</textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ $vendor->location ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" name="contact" id="contact" class="form-control" value="{{ $vendor->contact ?? '' }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
