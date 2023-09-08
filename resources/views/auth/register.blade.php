<x-guest-layout>
  <div class="mb-4 mt-6 bg-white shadow sm:rounded-lg">

    <!-- image + title -->
    <div class="border-b px-6 py-4">
      <img class="mx-auto mb-4 block w-28 text-center"
           src="img/logo-login.png"
           alt="logo" />

      <h2 class="mb-2 text-center font-bold">{{ __('Welcome to Bivouac') }}</h2>
      <h3 class="text-center text-sm text-gray-700">{{ __('Start managing your projects in less than a minute.') }}</h3>
    </div>

    <form method="POST"
          action="{{ route('register') }}">
      @csrf

      <div class="border-b px-6 py-4">
        <!-- first name and last name -->
        <div class="mb-4 flex justify-between">
          <div class="mr-4">
            <x-input-label for="first_name"
                           :value="__('First name')" />
            <x-text-input class="mt-1 block w-full"
                          id="first_name"
                          name="first_name"
                          type="text"
                          :value="old('first_name')"
                          required
                          autofocus
                          autocomplete="first_name" />
            <x-input-error class="mt-2"
                           :messages="$errors->get('first_name')" />
          </div>

          <div>
            <x-input-label for="last_name"
                           :value="__('Last name')" />
            <x-text-input class="mt-1 block w-full"
                          id="last_name"
                          name="last_name"
                          type="text"
                          :value="old('last_name')"
                          required
                          autocomplete="last_name" />
            <x-input-error class="mt-2"
                           :messages="$errors->get('last_name')" />
          </div>
        </div>

        <!-- Email Address -->
        <div class="mb-4">
          <x-input-label for="email"
                         :value="__('Email')" />
          <x-text-input class="mt-1 block w-full"
                        id="email"
                        name="email"
                        type="email"
                        :value="old('email')"
                        required
                        autocomplete="username" />

          <x-input-help class="mt-2">
            {{ __('We will send you a verification email, and won\'t spam you.') }}
          </x-input-help>
          <x-input-error class="mt-2"
                         :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mb-4">
          <x-input-label for="password"
                         :value="__('Password')" />

          <x-text-input class="mt-1 block w-full"
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password" />

          <x-input-help class="mt-2">
            {{ __('Minimum 8 characters.') }}</x-input-help>

          <x-input-error class="mt-2"
                         :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div>
          <x-input-label for="password_confirmation"
                         :value="__('Confirm password')" />

          <x-text-input class="mt-1 block w-full"
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password" />

          <x-input-error class="mt-2"
                         :messages="$errors->get('password_confirmation')" />
        </div>
      </div>

      <!-- organization -->
      <div class="border-b px-6 py-4">
        <x-input-label for="organization_name"
                       :value="__('Organization name')" />
        <x-text-input class="mt-1 block w-full"
                      id="organization_name"
                      name="organization_name"
                      type="text"
                      :value="old('organization')"
                      required
                      autocomplete="organization_name" />
        <x-input-error class="mt-2"
                       :messages="$errors->get('organization_name')" />
      </div>

      <!-- actions -->
      <div class="flex items-center justify-end px-6 py-4">
        <x-primary-button class="w-full text-center">
          {{ __('Create your account') }}
        </x-primary-button>
      </div>
    </form>
  </div>

  <div class="mb-6 rounded-lg border bg-white py-4 text-center shadow">
    <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
       href="{{ route('login') }}">
      {{ __('Do you already have an account?') }}
    </a>
  </div>
</x-guest-layout>
