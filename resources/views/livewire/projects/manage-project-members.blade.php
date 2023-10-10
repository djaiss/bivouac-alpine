<div>
  <!-- list of potential users -->
  @if ($showAddModal)
    <div class="mx-auto mb-4 max-w-2xl bg-white shadow sm:rounded-lg">
      <!-- header -->
      <div class="flex items-center justify-between border-b px-4 py-2">
        <p class="font-bold">{{ __('Add a user to this project') }}</p>

        <x-heroicon-s-x-mark class="h-5 w-5 cursor-pointer rounded text-gray-400 hover:bg-gray-300 hover:text-gray-600 group-hover:block" wire:click="toggle" />
      </div>
      <div wire:loading>{{ __('Loading users...') }}</div>

      <!-- list -->
      <ul class="max-h-40 overflow-auto">
        @foreach ($potentialMembers as $user)
          <li class="flex items-center justify-between py-4 pl-4 pr-6 hover:bg-slate-50 last:hover:rounded-b-lg" wire:key="{{ $user['id'] }}">
            <div class="flex">
              <x-avatar class="mr-2 h-6 w-6 rounded" :data="$user['avatar']" />
              <div>{{ $user['name'] }}</div>
            </div>

            <!-- add button -->
            <span class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200" wire:click="add({{ $user['id'] }})">
              {{ __('Add') }}
            </span>
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="mx-auto max-w-2xl bg-white shadow sm:rounded-lg">
    <!-- header -->
    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-2">
      <h2 class="text-lg font-medium text-gray-900">
        {{ __('Project members') }}
      </h2>

      @if (!$showAddModal)
        <x-primary-button wire:click="toggle">{{ __('Add member') }}</x-primary-button>
      @endif
    </div>

    <!-- list of users -->
    <ul class="w-full">
      @foreach ($members as $member)
        <li class="flex items-center justify-between border-b py-4 pl-4 pr-6 last:border-b-0 hover:bg-slate-50 last:hover:rounded-b-lg" wire:key="{{ $member['id'] }}">
          <div class="group mr-4 flex items-center">
            <x-avatar class="mr-2 h-6 w-6 rounded" :data="$member['avatar']" />

            <x-link :href="'member.url.show'">
              {{ $member['name'] }}
            </x-link>
          </div>

          <!-- actions -->
          @if ($member['id'] !== auth()->user()->id)
            <div class="">
              <x-link class="text-sm" href="{{ route('project.member.delete', ['project' => $projectId, 'user' => $member['id']]) }}" wire:navigate>{{ __('Remove from project') }}</x-link>
            </div>
          @endif
        </li>
      @endforeach
    </ul>
  </div>
</div>
