<x-app-layout>
  <!-- header -->
  <div class="mb-6">
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
              <span class="ml-1 text-sm text-gray-500 dark:text-gray-400 md:ml-2">{{ __('Manage organization') }}</span>
            </div>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="pb-12">
    <div class="mx-auto flex max-w-4xl sm:px-6 lg:px-8">
      <div class="w-full">
        <div class="bg-white shadow sm:rounded-lg">
          <!-- title -->
          <div class="flex items-center justify-between border-b border-gray-200 px-4 py-2">
            <h2 class="text-lg font-medium text-gray-900">
              {{ __('Name of the organization') }}
            </h2>
          </div>

          <!-- instructions -->
          <div class="flex">
            <div class="mr-8 w-96 p-4 text-sm">
              {{ __('The organization name appears almost everywhere in the application.') }}
            </div>

            <div class="w-full p-4">
              <form class="max-w-5xl space-y-4"
                    method="POST"
                    action="{{ route('settings.organization.store') }}">

                @csrf
                <!-- name -->
                <div>
                  <x-input-label for="email"
                                 :value="__('What is the name of the organization?')" />

                  <x-text-input class="mt-1 block w-full"
                                id="name"
                                name="name"
                                type="text"
                                value="{{ $view['name'] }}"
                                required
                                autofocus />

                  <x-input-error class="mt-2"
                                 :messages="$errors->get('name')" />
                </div>

                <!-- actions -->
                <div>
                  <x-primary-button class="text-center">
                    {{ __('Save') }}
                  </x-primary-button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
