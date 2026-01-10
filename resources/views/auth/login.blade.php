<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-4 sm:pt-0 bg-gray-100 px-4">
        <div class="flex flex-col items-center">
            <a href="/">
                <x-application-logo class="w-16 h-16 sm:w-24 sm:h-24 fill-current text-gray-500" />
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mt-2 sm:mt-4">Dashboard Admin</h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1 sm:mt-2">Sign in to your account</p>
        </div>

        <div class="w-full sm:max-w-md mt-4 sm:mt-8 px-4 sm:px-6 py-6 sm:py-8 bg-white shadow-lg overflow-hidden rounded-xl">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- CAPTCHA -->
                <div class="mt-4">
                    <x-input-label :value="__('Verifikasi CAPTCHA')" class="mb-2" />
                    <div class="flex items-center gap-2">
                        <!-- Kotak 1 - Angka Random -->
                        <div id="captcha_num1" class="w-10 h-8 flex items-center justify-center bg-white border border-gray-300 text-gray-700 font-medium text-sm rounded">
                            {{ $captcha_num1 }}
                        </div>

                        <!-- Tanda + -->
                        <span class="text-sm font-medium text-gray-500">+</span>

                        <!-- Kotak 2 - Angka Random -->
                        <div id="captcha_num2" class="w-10 h-8 flex items-center justify-center bg-white border border-gray-300 text-gray-700 font-medium text-sm rounded">
                            {{ $captcha_num2 }}
                        </div>

                        <!-- Tanda = -->
                        <span class="text-sm font-medium text-gray-500">=</span>

                        <!-- Kotak 3 - Input User -->
                        <input
                            type="text"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            name="captcha_answer"
                            id="captcha_answer"
                            class="w-14 h-8 text-center text-sm font-medium bg-white border border-gray-300 rounded"
                            style="outline: none !important; box-shadow: none !important;"
                            placeholder=""
                            required>
                    </div>
                    <x-input-error :messages="$errors->get('captcha_answer')" class="mt-2" />
                </div>

                <div class="flex flex-col items-center mt-6 space-y-4">
                    <x-primary-button class="w-full justify-center py-3 text-lg">
                        {{ __('Log in') }}
                    </x-primary-button>

                    @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const num1 = parseInt(document.getElementById('captcha_num1').textContent.trim());
            const num2 = parseInt(document.getElementById('captcha_num2').textContent.trim());
            const correctAnswer = num1 + num2;
            const input = document.getElementById('captcha_answer');

            input.addEventListener('input', function() {
                const userAnswer = parseInt(this.value);

                if (this.value === '') {
                    this.style.borderColor = '#d1d5db'; // gray-300
                } else if (userAnswer === correctAnswer) {
                    this.style.borderColor = '#22c55e'; // green-500
                } else {
                    this.style.borderColor = '#ef4444'; // red-500
                }
            });
        });
    </script>
</body>

</html>