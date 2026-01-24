@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center"
    style="min-height: 80vh">

    <div class="card shadow-sm" style="width: 450px">
        <div class="card-body">

            <h3 class="text-center mb-4">
                Create Account
            </h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label>Name</label>
                    <input
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                        required>
                    @error('email')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        required
                        minlength="8"
                        oninput="validatePasswords()">

                    <small
                        id="password-warning"
                        class="text-danger"
                        style="display:none">
                        Password must be at least 8 characters
                    </small>
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control"
                        required
                        oninput="validatePasswords()">

                    <small
                        id="confirm-warning"
                        class="text-danger"
                        style="display:none">
                        Passwords do not match
                    </small>
                </div>

                <button
                    id="registerBtn"
                    class="btn btn-success w-100 mb-3"
                    disabled>
                    Register
                </button>
            </form>

            <div class="text-center">
                <a href="{{ route('login') }}">
                    Already have an account? Login
                </a>
            </div>

        </div>
    </div>

</div>

<script>
    function validatePasswords() {
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;

        const passwordWarning = document.getElementById('password-warning');
        const confirmWarning = document.getElementById('confirm-warning');
        const btn = document.getElementById('registerBtn');

        let valid = true;

        if (password.length < 8) {
            passwordWarning.style.display = 'block';
            valid = false;
        } else {
            passwordWarning.style.display = 'none';
        }

        if (confirm && password !== confirm) {
            confirmWarning.style.display = 'block';
            valid = false;
        } else {
            confirmWarning.style.display = 'none';
        }

        btn.disabled = !valid;
    }
</script>
@endsection