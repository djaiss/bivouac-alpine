@props(['data'])

<div class="bg-white shadow sm:rounded-lg">
  <div class="border-b border-gray-200 p-4">
    <!-- project name -->
    <div class="flex w-full items-center">
      @if (!$data['is_public'])
        <x-icon-lock />
      @endif
      <h1 class="text-2xl font-bold">{{ $data['name'] }}</h1>
    </div>

    <!-- short description -->
    @if ($data['short_description'])
      <p class="mt-1 text-sm">{{ $data['short_description'] }}</p>
    @endif
  </div>

  <!-- menu -->
  <div class="px-4">
    <div class="text-center text-gray-500 dark:text-gray-400">
      <ul class="-mb-px flex flex-wrap">
        <li class="mr-2">
          <a class="inline-block rounded-t-lg border-b-2 p-3 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300" href="{{ route('project.show', ['project' => $data['id']]) }}" wire:navigate>
            {{ __('Summary') }}
          </a>
        </li>
        <li class="mr-2">
          <a class="inline-block rounded-t-lg border-b-2 p-3 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300" href="{{ route('project.message.index', ['project' => $data['id']]) }}" wire:navigate.hover>
            {{ __('Messages') }}
          </a>
        </li>
        <li class="mr-2">
          <a class="inline-block rounded-t-lg border-b-2 border-transparent p-3 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300" href="#" wire:navigate>
            {{ __('Decisions') }}
          </a>
        </li>
        <li class="mr-2">
          <a class="inline-block rounded-t-lg border-b-2 p-3 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300" href="{{ route('project.tasklist.index', ['project' => $data['id']]) }}" wire:navigate>
            {{ __('Tasks') }}
          </a>
        </li>
        <li class="mr-2">
          <a class="inline-block rounded-t-lg border-b-2 border-transparent p-3 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300" href="#" wire:navigate>
            {{ __('Files') }}
          </a>
        </li>
        <li class="mr-2">
          <a class="inline-block rounded-t-lg border-b-2 p-3 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300" href="{{ route('project.member.index', ['project' => $data['id']]) }}" wire:navigate>
            {{ __('Members') }}
          </a>
        </li>
        <li class="mr-2">
          <a class="inline-block rounded-t-lg border-b-2 p-3 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300" href="{{ route('project.edit', ['project' => $data['id']]) }}" wire:navigate.hover>
            {{ __('Settings') }}
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
