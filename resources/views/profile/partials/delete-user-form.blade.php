<p class="text-muted mb-3">Once your account is deleted, all of its resources and data will be permanently deleted.</p>

<form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
    @csrf
    @method('delete')
    <div class="mb-3">
        <label for="delete_password" class="form-label">Confirm your password</label>
        <input id="delete_password" name="password" type="password"
               class="form-control @if($errors->userDeletion->has('password')) is-invalid @endif"
               placeholder="Enter your password to confirm">
        @if($errors->userDeletion->has('password'))
            <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
        @endif
    </div>
    <button type="submit" class="btn btn-danger">Delete Account</button>
</form>
