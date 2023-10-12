<x-app-layout>
  <!-- header -->
  <div class="mb-12">
    <div class="bg-white px-4 py-2 shadow">
      <!-- Breadcrumb -->
      <nav class="flex py-3 text-gray-700">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center">
            <x-link class="text-sm" href="{{ route('dashboard') }}" wire:navigate>{{ __('Home') }}</x-link>
          </li>
          <li class="inline-flex items-center">
            <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
            <x-link class="text-sm" href="{{ route('project.tasklist.index', ['project' => $header['id']]) }}" wire:navigate>{{ $header['name'] }}</x-link>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Edit a task list') }}</span>
            </div>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="pb-12">
    <div class="mx-auto max-w-lg overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-800">
      <form method="POST" action="{{ route('project.tasklist.update', ['project' => $header['id'], 'tasklist' => $view['id']]) }}">
        @method('PUT')
        @csrf

        <div class="relative border-b px-6 py-4">
          <h1 class="text-center text-lg font-bold">{{ __('Edit a task list') }}</h1>
        </div>

        <!-- Title -->
        <div class="relative px-6 py-4">
          <x-input-label for="name" :value="__('What is the name of the list?')" />

          <x-text-input class="mt-1 block w-full"
                        id="title"
                        name="title"
                        type="text"
                        required
                        :value="old('title', $view['title'])"
                        autofocus />

          <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <!-- actions -->
        <div class="flex items-center justify-between border-t bg-gray-50 px-6 py-4">
          <x-link :href="route('project.tasklist.index', ['project' => $header['id']])" wire:navigate.hover>{{ __('Back') }}</x-link>

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
