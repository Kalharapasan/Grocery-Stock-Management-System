<p class="text-muted mb-3">Ensure your account is using a long, random password to stay secure.</p>

<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')
    <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input id="current_password" name="current_password" type="password"
               class="form-control @if($errors->updatePassword->has('current_password')) is-invalid @endif">
        @if($errors->updatePassword->has('current_password'))
            <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <input id="password" name="password" type="password"
               class="form-control @if($errors->updatePassword->has('password')) is-invalid @endif">
        @if($errors->updatePassword->has('password'))
            <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    @if (session('status') === 'password-updated')
        <span class="text-success ms-2">Saved.</span>
    @endif
</form>
