<x-guest-layout>
  <div class="mb-4 mt-6 bg-white shadow sm:rounded-lg">
    <div class="border-b px-6 py-4">
      <img class="mx-auto mb-4 block w-28 text-center" src="img/logo-register.png" alt="logo" />

      <h2 class="mb-2 text-center font-bold">Welcome back to Bivouac</h2>
      <h3 class="text-center text-sm text-gray-700">Hope you are having a great day.</h3>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- form -->
    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="border-b px-6 py-4">
        <!-- Email Address -->
        <div class="mb-4">
          <x-input-label for="email" :value="__('Email')" />
          <x-text-input class="mt-1 block w-full"
                        id="email"
                        name="email"
                        type="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username" />
          <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mb-4">
          <div class="flex justify-between">
            <x-input-label for="password" :value="__('Password')" />

            @if (Route::has('password.request'))
              <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
              </a>
            @endif
          </div>

          <x-text-input class="mt-1 block w-full"
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password" />

          <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me -->
        <div class="block">
          <label class="inline-flex items-center" for="remember_me">
            <input class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                   id="remember_me"
                   name="remember"
                   type="checkbox">
            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
          </label>
        </div>
      </div>

      <div class="flex items-center justify-end px-6 py-4">
        <x-primary-button class="w-full text-center">
          {{ __('Log in') }}
        </x-primary-button>
      </div>
    </form>
  </div>
</x-guest-layout>
