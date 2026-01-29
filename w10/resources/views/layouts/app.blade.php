<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Product Management System') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">

    {{-- Navigation --}}
    @include('layouts.navigation')

    {{-- Page Content --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- Toast Logic --}}
    @php
    $toastType = session('toast_type');

    $toastClass = match($toastType) {
    'create' => 'bg-success text-white',
    'update' => 'bg-primary text-white',
    'delete' => 'bg-danger text-white',
    default => 'bg-dark text-white',
    };
    @endphp

    {{-- Toast --}}
    @if(session('toast_message'))
    <div class="toast-container position-fixed bottom-0 end-0 p-4"
        style="z-index: 1100">

        <div id="successToast"
            class="toast border-0 shadow-sm {{ $toastClass }}"
            role="alert"
            aria-live="assertive"
            aria-atomic="true">

            <div class="d-flex align-items-center">
                <div class="toast-body fw-semibold">
                    {{ session('toast_message') }}
                </div>

                <button type="button"
                    class="btn-close btn-close-white me-3"
                    data-bs-dismiss="toast"
                    aria-label="Close">
                </button>
            </div>

        </div>
    </div>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toast Init -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastEl = document.getElementById('successToast');

            if (toastEl) {
                new bootstrap.Toast(toastEl, {
                    delay: 5000 // 5 seconds
                }).show();
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-btn')) {
                const productId = e.target.dataset.id;

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This product will be permanently deleted!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document
                            .getElementById('delete-form-' + productId)
                            .submit();
                    }
                });
            }
        });
    </script>



</body>

</html>