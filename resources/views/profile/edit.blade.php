@extends('layouts.app')

@section('title', 'Profile - Grocery Stock Manager')

@section('content')
<h3 class="mb-4"><i class="bi bi-gear"></i> Profile Settings</h3>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Profile Information</h5></div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Update Password</h5></div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="card border-danger mb-4">
            <div class="card-header bg-danger text-white"><h5 class="mb-0">Delete Account</h5></div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
