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
            <x-link class="text-sm" href="{{ route('project.message.index', ['project' => $header['id']]) }}" wire:navigate>{{ $header['name'] }}</x-link>
          </li>
          <li class="inline-flex items-center">
            <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
            <x-link class="text-sm" href="{{ route('project.message.show', ['project' => $header['id'], 'message' => $view['message_id']]) }}" wire:navigate>{{ $view['message_title'] }}</x-link>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Delete comment') }}</span>
            </div>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="pb-12">
    <div class="mx-auto max-w-lg overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-800">
      <form method="POST" action="{{ route('project.message.comment.destroy', ['project' => $header['id'], 'message' => $view['message_id'], 'comment' => $view['id']]) }}">

        @csrf
        @method('delete')

        <div class="relative border-b px-6 py-4">
          <div class="h-3w-32 relative mx-auto mb-4 w-32 overflow-hidden rounded-full">
            <img class="mx-auto block text-center" src="/img/invite.png" alt="logo" />
          </div>

          <h1 class="text-center text-lg font-bold">
            {{ __('Delete the comment') }}
          </h1>
        </div>

        <div class="relative border-b px-6 py-4">
          <p>
            {{ __('Are you certain? This cannot be recovered.') }}
          </p>
        </div>

        <!-- actions -->
        <div class="flex items-center justify-between bg-gray-50 px-6 py-4">
          <x-link href="{{ route('project.message.show', ['project' => $header['id'], 'message' => $view['message_id']]) }}" wire:navigate>{{ __('Back') }}</x-link>

          <div>
            <x-danger-button class="w-full text-center">
              {{ __('Delete') }}
            </x-danger-button>
          </div>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
