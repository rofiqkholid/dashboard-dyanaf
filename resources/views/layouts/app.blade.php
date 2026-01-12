<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- NProgress -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation', ['pageTitle' => $header ?? null])

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Global Confirm Modal -->
    <x-confirm-modal />

    <!-- NProgress Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <style>
        #nprogress .bar {
            background: #2563eb !important;
            /* blue-600 */
            height: 3px !important;
        }

        #nprogress .peg {
            box-shadow: 0 0 10px #2563eb, 0 0 5px #2563eb !important;
        }
    </style>
    <script>
        NProgress.configure({
            showSpinner: false
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Links
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', (e) => {
                    const href = link.getAttribute('href');
                    const target = link.getAttribute('target');
                    if (href && !href.startsWith('#') && target !== '_blank' && !e.ctrlKey && !e.metaKey) {
                        NProgress.start();
                    }
                });
            });

            // Forms
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => NProgress.start());
            });
        });

        // Mobile specific handling or history back
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                NProgress.done();
            }
        });
    </script>
</body>

</html>