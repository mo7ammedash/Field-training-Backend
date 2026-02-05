@extends('layouts.app')

@section('content')

{{-- Success message after register --}}
@if(session('success'))
<div style="
        border: 1px solid #b7e4c7;
        background-color: #d8f3dc;
        color: #1b4332;
        padding: 12px 16px;
        margin-bottom: 20px;
        border-radius: 6px;
        text-align: center;
        font-weight: 500;
        max-width: 420px;
        margin-left: auto;
        margin-right: auto;
    ">
    {{ session('success') }}
</div>
@endif

<div class="container d-flex justify-content-center align-items-center"
    style="min-height: 80vh">

    <div class="card"
        style="
            width: 420px;
            border-radius: 10px;
            border: 1px solid #eee;
         ">

        <div class="card-body p-4">

            {{-- Title --}}
            <h3 class="text-center mb-1" style="font-weight: 700;">
                Product Management System
            </h3>
            <p class="text-center text-muted mb-4" style="font-size: 14px;">
                Login to manage your products
            </p>

            {{-- Login error --}}
            @if ($errors->has('email'))
            <div style="
                    border: 1px solid #f5c2c7;
                    background-color: #f8d7da;
                    color: #842029;
                    padding: 10px 14px;
                    margin-bottom: 15px;
                    border-radius: 6px;
                    text-align: center;
                    font-weight: 500;
                ">
                Invalid email or password.
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Email
                    </label>
                    <input type="email"
                        name="email"
                        class="form-control"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        required
                        autofocus>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Password
                    </label>
                    <input type="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter your password"
                        required>
                </div>

                {{-- Remember --}}
                <div class="form-check mb-3">
                    <input class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember">
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                <button class="btn btn-primary w-100 mb-3"
                    style="font-weight: 600;">
                    Login
                </button>
            </form>

            <div class="text-center" style="font-size: 14px;">
                <span class="text-muted">
                    Don’t have an account?
                </span>
                <a href="{{ route('register') }}" class="fw-semibold">
                    Register
                </a>
            </div>

        </div>
    </div>

</div>
@endsection