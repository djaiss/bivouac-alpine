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
          <li class="inline-flex items-center">
            <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
            <x-link wire:navigate class="text-sm"
                    href="{{ route('project.index') }}">{{ __('List of projects') }}</x-link>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <span class="ml-1 text-sm text-gray-500 dark:text-gray-400 md:ml-2">{{ __('Create a project') }}</span>
            </div>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="pb-12">
    <div class="mx-auto max-w-lg overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-800">
      <form method="POST"
            action="{{ route('project.store') }}">
        @csrf

        <div class="relative border-b px-6 py-4">
          <div class="h-3w-32 relative mx-auto mb-4 w-32 overflow-hidden rounded-full">
            <img class="mx-auto block text-center"
                 src="/img/project_create.png"
                 alt="logo" />
          </div>
          <h1 class="mb-2 text-center text-lg font-bold">{{ __('Create a project') }}</h1>
          <h3 class="text-center text-sm text-gray-700">
            {{ __('Projects are at the heart of everything in the organization.') }}
          </h3>
        </div>

        <div class="relative border-b px-6 py-4">
          <!-- Title -->
          <div class="mb-4">
            <x-input-label class="mb-1"
                           for="title"
                           :value="__('What is the name of the project?')" />

            <x-text-input class="block w-full"
                          id="title"
                          name="title"
                          type="text"
                          :value="old('title')"
                          required
                          autofocus />

            <x-input-error class="mt-2"
                           :messages="$errors->get('name')" />
          </div>

          <!-- Description -->
          <div>
            <x-input-label class="mb-1"
                           for="description"
                           :optional="true"
                           :value="__('Provide a short description for this project.')" />

            <x-textarea class="block w-full"
                        id="description"
                        name="description"
                        type="text"
                        :value="old('description')" />

            <x-input-error class="mt-2"
                           :messages="$errors->get('description')" />
          </div>
        </div>

        <!-- privacy -->
        <div class="space-y-2 px-6 py-4">
          <div class="flex items-center gap-x-2">
            <input class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                   id="hidden"
                   name="is_public"
                   type="radio"
                   value="true"
                   checked="checked" />

            <label class="block text-sm font-medium leading-6 text-gray-900"
                   for="hidden">
              {{ __('Public: everyone can see and participate') }}
            </label>
          </div>
          <div class="flex items-center gap-x-2">
            <input class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                   id="month_day"
                   name="is_public"
                   type="radio"
                   value="false" />

            <label class="block text-sm font-medium leading-6 text-gray-900"
                   for="month_day">
              {{ __('Private: only selected users can access this project') }}
            </label>
          </div>
        </div>

        <!-- action -->
        <div class="flex items-center justify-between border-t bg-gray-50 px-6 py-4">
          <x-link wire:navigate href="{{ route('project.index') }}">{{ __('Back') }}</x-link>

          <div>
            <x-primary-button class="w-full text-center">
              {{ __('Create') }}
            </x-primary-button>
          </div>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
