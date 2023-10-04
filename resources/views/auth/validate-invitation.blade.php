<x-guest-layout>
  <form class="mb-4 mt-6 bg-white shadow sm:rounded-lg" method="POST" action="{{ $view['url']['store'] }}">
    @csrf
    <div class="border-b px-6 py-4">
      <img class="mx-auto mb-4 block w-28 text-center" src="/img/confirm-invite.png" alt="logo" />

      <h2 class="mb-2 text-center font-bold">{{ __('You have been invited to Bivouac') }}</h2>
      <h3 class="text-center text-sm text-gray-700">
        {{ __('Please fill in these fields to finalize your account.') }}
      </h3>
    </div>

    <!-- first name and last name -->
    <div class="border-b px-6 py-4">
      <div class="mb-4 flex justify-between">
        <div class="mr-4">
          <x-input-label for="first_name" :value="__('First name')" />
          <x-text-input class="mt-1 block w-full"
                        id="first_name"
                        name="first_name"
                        type="text"
                        :value="old('first_name')"
                        required
                        autofocus
                        autocomplete="first_name" />
          <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <div>
          <x-input-label for="last_name" :value="__('Last name')" />
          <x-text-input class="mt-1 block w-full"
                        id="last_name"
                        name="last_name"
                        type="text"
                        :value="old('last_name')"
                        required
                        autocomplete="last_name" />
          <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>
      </div>

      <div>
        <x-input-label for="password" :value="__('Password')" />

        <x-text-input class="mt-1 block w-full"
                      id="password"
                      name="password"
                      type="password"
                      required
                      autocomplete="new-password" />

        <x-input-help class="mt-2">
          {{ __('Minimum 8 characters.') }}</x-input-help>

        <x-input-error class="mt-2" :messages="$errors->get('password')" />
      </div>
    </div>

    <!-- actions -->
    <div class="flex items-center justify-end px-6 py-4">
      <x-primary-button class="w-full text-center">
        {{ __('Create your account') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout>
