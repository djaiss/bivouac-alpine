<x-app-layout>
  <!-- header -->
  <div class="mb-12">
    <div class="bg-white px-4 py-2 shadow">
      <!-- Breadcrumb -->
      <nav class="flex py-3 text-gray-700">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center">
            <x-link wire:navigate class="text-sm"
                    href="{{ route('dashboard') }}">{{ __('Home') }}</x-link>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <x-link wire:navigate class="text-sm"
                      href="{{ route('settings.index') }}">{{ __('Account settings') }}</x-link>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <x-link wire:navigate class="text-sm"
                      href="{{ route('settings.role.index') }}">{{ __('Manage roles') }}</x-link>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <span class="ml-1 text-sm text-gray-500 dark:text-gray-400 md:ml-2">{{ __('Add a new role') }}</span>
            </div>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="pb-12">
    <div class="mx-auto max-w-lg overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-800">
      <form method="POST"
            action="{{ route('settings.role.store') }}">

        @csrf

        <div class="relative border-b px-6 py-4">
          <div class="h-3w-32 relative mx-auto mb-4 w-32 overflow-hidden rounded-full">
            <img class="mx-auto block text-center"
                 src="/img/office_create.png"
                 alt="logo" />
          </div>
          <h1 class="mb-2 text-center text-lg font-bold">{{ __('Add a role') }}</h1>
        </div>

        <div class="relative px-6 py-4">
          <x-input-label for="name"
                         :value="__('What is the name of this role?')" />

          <x-text-input class="mt-1 block w-full"
                        id="label"
                        name="label"
                        type="text"
                        required
                        autofocus />

          <x-input-error class="mt-2"
                         :messages="$errors->get('label')" />
        </div>

        <!-- actions -->
        <div class="flex items-center justify-between border-t bg-gray-50 px-6 py-4">
          <x-link wire:navigate href="{{ route('settings.role.index') }}">{{ __('Back') }}</x-link>

          <div>
            <x-primary-button class="w-full text-center">
              {{ __('Add') }}
            </x-primary-button>
          </div>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
