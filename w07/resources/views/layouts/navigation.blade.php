<nav class="bg-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center py-2">

        <!-- Logo -->
        <a href="{{ auth()->check() ? route('products.index') : route('login') }}"
            class="text-white fw-bold text-decoration-none fs-5">
            Product Management System
        </a>

        <!-- Right Side -->
        <div class="d-flex align-items-center gap-2">

            @auth
            <span class="text-white">
                {{ auth()->user()->name }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    Logout
                </button>
            </form>
            @endauth

            @guest
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                Login
            </a>
            <a href="{{ route('register') }}" class="btn btn-success btn-sm">
                Register
            </a>
            @endguest

        </div>

    </div>
</nav>