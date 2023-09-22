@props(['data'])

<section>
  <header class="w-full">
    <h2 class="border-b border-gray-200 px-4 py-2 text-lg font-medium text-gray-900">
      {{ __('Profile information') }}
    </h2>
  </header>

  <div class="flex">
    <!-- instructions -->
    <div class="mr-8 w-96 p-4 text-sm">
      {{ __('This information is publicly available within the organization. Everyone can read it.') }}
    </div>

    <div class="p-4">
      <form class="max-w-3xl space-y-6"
            method="post"
            action="{{ route('user.update', ['user' => $data['id']]) }}">

        @csrf
        @method('PUT')

        <div class="flex">
          <!-- first name -->
          <div class="mr-4 w-full">
            <x-input-label class="mb-1"
                           for="first_name"
                           :value="__('First name')" />

            <x-text-input class="block w-full"
                          id="first_name"
                          name="first_name"
                          type="text"
                          :value="old('first_name', $data['first_name'])"
                          required
                          autofocus
                          autocomplete="first_name" />

            <x-input-error class="mt-2"
                           :messages="$errors->get('first_name')" />
          </div>

          <!-- last name -->
          <div class="w-full">
            <x-input-label class="mb-1"
                           for="last_name"
                           :value="__('Last name')" />

            <x-text-input class="block w-full"
                          id="last_name"
                          name="last_name"
                          type="text"
                          :value="old('last_name', $data['last_name'])"
                          required
                          autocomplete="last_name" />

            <x-input-error class="mt-2"
                           :messages="$errors->get('last_name')" />
          </div>
        </div>

        <!-- email -->
        <div>
          <x-input-label class="mb-1"
                         for="email"
                         :value="__('Email address')" />

          <x-text-input class="mb-2 block w-full"
                        id="email"
                        name="email"
                        type="email"
                        :value="old('email', $data['email'])"
                        required
                        autofocus
                        autocomplete="email" />

          <x-input-help :value="__('We will send you a verification email to confirm that you own the email address.')" />

          <x-input-error class="mt-2"
                         :messages="$errors->get('email')" />
        </div>

        <x-primary-button>
          {{ __('Save') }}
        </x-primary-button>
      </form>
    </div>
  </div>
</section>
