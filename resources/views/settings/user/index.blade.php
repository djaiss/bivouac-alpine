<x-app-layout>
  <!-- header -->
  <div class="mb-6">
    <div class="bg-white px-4 py-2 shadow">
      <!-- Breadcrumb -->
      <nav class="flex py-3 text-gray-700">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center">
            <x-link class="text-sm" href="{{ route('dashboard') }}">{{ __('Home') }}</x-link>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <x-link class="text-sm" href="{{ route('settings.index') }}">{{ __('Account settings') }}</x-link>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Manage users') }}</span>
            </div>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="pb-12">
    <div class="mx-auto flex max-w-5xl sm:px-6 lg:px-8">
      <div class="w-full">
        <div class="bg-white shadow sm:rounded-lg">
          <!-- title -->
          <div class="flex items-center justify-between border-b border-gray-200 px-4 py-2">
            <h2 class="text-lg font-medium text-gray-900">
              {{ __('All the users who have access to this account') }}
            </h2>

            <div>
              <x-primary-link :href="route('settings.user.create')">{{ __('Invite user') }}</x-primary-link>
            </div>
          </div>

          <!-- list of users -->
          <ul class="w-full">
            @foreach ($view['users'] as $user)
              <li class="group flex items-center justify-between px-6 py-4 hover:bg-slate-100 last:hover:rounded-b-lg">

                <!-- user information -->
                <div class="flex items-center">
                  <x-avatar class="mr-4 h-8 w-8 rounded" :data="$user['avatar']" />

                  <div class="mr-6 flex flex-col">
                    <!-- name + invitation status -->
                    <div class="flex">
                      <div class="mr-2 font-bold">{{ $user['name'] }}</div>
                      @if (!$user['verified'])
                        <span class="flex items-center rounded-lg border border-yellow-300 bg-yellow-50 px-2 py-0 text-xs">
                          <span class="text-yellow-600">{{ __('invited') }}</span>
                        </span>
                      @endif
                    </div>

                    <div class="flex">
                      <div class="mr-4 inline text-sm">
                        <span class="flex items-center">
                          <x-heroicon-s-envelope class="mr-2 h-3 w-3 text-gray-400" />
                          <span>{{ $user['email'] }}</span>
                        </span>
                      </div>
                      <div class="inline text-sm">
                        <span class="flex items-center">
                          <x-heroicon-s-key class="mr-2 h-3 w-3 text-gray-400" />
                          {{ $user['permissions'] }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- menu -->
                @if ($user['can_delete'])
                  <ul>
                    @if (!$user['verified'])
                      <li class="mr-2 inline">
                        <form class="inline" method="POST" action="{{ $user['url']['send'] }}">
                          @csrf
                          <a class="cursor-pointer text-sm text-blue-700 underline hover:rounded-sm hover:bg-blue-700 hover:text-white" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Send invitation again') }}</a>
                        </form>
                      </li>
                    @endif
                    <li class="mr-2 inline"><x-link class="text-sm" href="{{ $user['url']['edit'] }}">{{ __('Edit') }}</x-link>
                    </li>
                    <li class="inline"><x-link class="text-sm" href="{{ $user['url']['delete'] }}">{{ __('Delete') }}</x-link>
                    </li>
                  </ul>
                @endif
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
