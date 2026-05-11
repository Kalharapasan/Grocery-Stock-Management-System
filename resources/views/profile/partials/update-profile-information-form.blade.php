<p class="text-muted mb-3">Update your account's profile information and email address.</p>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name) }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email) }}" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    @if (session('status') === 'profile-updated')
        <span class="text-success ms-2">Saved.</span>
    @endif
</form>
