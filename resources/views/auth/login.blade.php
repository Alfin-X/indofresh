<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" title="Data harus diisi" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Kata Sandi" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" title="Data harus diisi" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif

            <x-primary-button class="ms-3">
                Masuk
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set custom validation messages for HTML5 validation
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            if (emailInput) {
                emailInput.addEventListener('invalid', function() {
                    if (this.validity.valueMissing) {
                        this.setCustomValidity('Data harus diisi');
                    } else if (this.validity.typeMismatch) {
                        this.setCustomValidity('Format email tidak valid');
                    } else {
                        this.setCustomValidity('');
                    }
                });

                emailInput.addEventListener('input', function() {
                    this.setCustomValidity('');
                });
            }

            if (passwordInput) {
                passwordInput.addEventListener('invalid', function() {
                    if (this.validity.valueMissing) {
                        this.setCustomValidity('Data harus diisi');
                    } else {
                        this.setCustomValidity('');
                    }
                });

                passwordInput.addEventListener('input', function() {
                    this.setCustomValidity('');
                });
            }
        });
    </script>
</x-guest-layout>
