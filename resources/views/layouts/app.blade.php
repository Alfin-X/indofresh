<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Indofresh') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Session Management Script -->
        <script>
            // Setup CSRF token for all AJAX requests
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };

            // Setup axios defaults if available
            if (typeof axios !== 'undefined') {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

                // Handle 419 responses globally
                axios.interceptors.response.use(
                    response => response,
                    error => {
                        if (error.response && error.response.status === 419) {
                            if (confirm('Your session has expired. Would you like to refresh the page?')) {
                                window.location.reload();
                            } else {
                                window.location.href = '{{ route("login") }}';
                            }
                        }
                        return Promise.reject(error);
                    }
                );
            }

            // Setup jQuery CSRF token if available
            if (typeof $ !== 'undefined') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken
                    }
                });

                // Handle 419 responses globally for jQuery
                $(document).ajaxError(function(event, xhr, settings) {
                    if (xhr.status === 419) {
                        if (confirm('Your session has expired. Would you like to refresh the page?')) {
                            window.location.reload();
                        } else {
                            window.location.href = '{{ route("login") }}';
                        }
                    }
                });
            }
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
