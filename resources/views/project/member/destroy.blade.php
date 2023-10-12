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
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <x-link class="text-sm" href="{{ route('project.index') }}" wire:navigate>{{ __('All the projects') }}</x-link>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <x-link class="text-sm" href="{{ route('project.member.index', ['project' => $header['id']]) }}" wire:navigate>{{ __('Manage project members') }}</x-link>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Remove the member from the project') }}</span>
            </div>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="pb-12">
    <div class="mx-auto max-w-lg overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-800">
      <form method="POST" action="{{ route('project.member.destroy', ['project' => $header['id'], 'user' => $view['id']]) }}">
        @csrf
        @method('delete')

        <div class="relative border-b px-6 py-4">
          <div class="h-3w-32 relative mx-auto mb-4 w-32 overflow-hidden rounded-full">
            <x-avatar class="mx-auto block rounded text-center" :data="$view['avatar']" />
          </div>
          <h1 class="text-center text-lg font-bold">{{ __('Remove the member from the project') }}
          </h1>
        </div>

        <div class="relative border-b px-6 py-4">
          <p>
            {{ __('Are you sure? You can always add this person back in the future.') }}
          </p>
        </div>

        <!-- actions -->
        <div class="flex items-center justify-between bg-gray-50 px-6 py-4">
          <x-link href="{{ route('project.member.index', ['project' => $header['id']]) }}" wire:navigate>{{ __('Back') }}</x-link>

          <div>
            <x-danger-button class="w-full text-center">
              {{ __('Remove member') }}
            </x-danger-button>
          </div>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
