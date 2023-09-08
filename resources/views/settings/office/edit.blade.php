<x-app-layout>
  <!-- header -->
  <div class="mb-12">
    <div class="bg-white px-4 py-2 shadow">
      <!-- Breadcrumb -->
      <nav class="flex py-3 text-gray-700">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center">
            <x-link class="text-sm"
                    href="{{ route('dashboard') }}">{{ __('Home') }}</x-link>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <x-link class="text-sm"
                      href="{{ route('settings.index') }}">{{ __('Account settings') }}</x-link>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <x-link class="text-sm"
                      href="{{ route('settings.office.index') }}">{{ __('Manage offices') }}</x-link>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <span class="ml-1 text-sm text-gray-500 dark:text-gray-400 md:ml-2">{{ __('Edit office') }}</span>
            </div>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="pb-12">
    <div class="mx-auto max-w-lg overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-800">
      <form method="post"
            action="{{ route('settings.office.update', ['office' => $view['id']]) }}">
        @csrf
        @method('PUT')

        <div class="relative border-b px-6 py-4">
          <div class="h-3w-32 relative mx-auto mb-4 w-32 overflow-hidden rounded-full">
            <img class="mx-auto block text-center"
                 src="/img/office_create.png"
                 alt="logo" />
          </div>
          <h1 class="mb-2 text-center text-lg font-bold">{{ __('Edit an office') }}</h1>
        </div>

        <div class="relative px-6 py-4">
          <x-input-label for="name"
                         :value="__(
                             'What is the name of the office? It can be the name of the city, the street or whatever defines this office.',
                         )" />

          <x-text-input class="mt-1 block w-full"
                        id="name"
                        name="name"
                        type="text"
                        required
                        :value="old('name', $view['name'])"
                        autofocus />

          <x-input-error class="mt-2"
                         :messages="$errors->get('name')" />

          <!-- main office -->
          <div class="mt-3 flex items-center">
            <input class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-neutral-900 focus:ring-neutral-900"
                   id="is_main_office"
                   name="is_main_office"
                   type="checkbox"
                   @checked(old('is_main_office', $view['is_main_office']))>
            <label class="ml-2 text-sm"
                   for="is_main_office">{{ __('Designate this office as the main office') }}</label>
          </div>
        </div>

        <!-- actions -->
        <div class="flex items-center justify-between border-t bg-gray-50 px-6 py-4">
          <x-link href="{{ route('settings.office.index') }}">{{ __('Back') }}</x-link>

          <div>
            <x-primary-button class="w-full text-center">
              {{ __('Save') }}
            </x-primary-button>
          </div>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
