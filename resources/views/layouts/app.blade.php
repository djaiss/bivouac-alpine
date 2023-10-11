<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bivouac') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
      <div class="flex min-h-screen flex-1 flex-col sm:flex-row">
        <!-- main content -->
        <main class="flex-1 bg-slate-100">
          @include('notify::components.notify')

          {{ $slot }}
        </main>

        <!-- sidebar -->
        <nav class="order-first bg-slate-800 sm:w-60">
          <div class="flex-1">
            <!-- Bivouac logo -->
            <div class="mb-6 bg-slate-900 px-8 py-4">
              <div class="flex items-center justify-center">
                <img class="mr-4 h-6 w-6 fill-current text-white" src="/img/logo.svg" alt="Bivouac logo" />
                <p class="app-name text-xl text-white">Bivouac</p>
              </div>
            </div>

            <!-- search and notifications -->
            <ul class="mb-4 border-b border-slate-700 pb-4 text-slate-400">
              <li class="group flex items-center px-4 py-2 hover:bg-slate-900 hover:text-white">
                <x-heroicon-s-magnifying-glass class="h-4 w-4 transition ease-in-out group-hover:fill-current group-hover:text-blue-500" />
                <a class="ml-2" href="{{ route('search.index') }}">{{ __('Search') }}</a>
              </li>

              <li class="group flex items-center px-4 py-2 hover:bg-slate-900 hover:text-white">
                <x-heroicon-s-bell class="h-4 w-4 transition ease-in-out group-hover:fill-current group-hover:text-blue-500" />
                <span class="ml-2">{{ __('Notifications') }}</span>
              </li>
            </ul>

            <!-- general menu -->
            <ul class="mb-4 border-b border-slate-700 pb-4 text-slate-400">
              <!-- dashboard -->
              <li class="group flex items-center px-4 py-2 hover:bg-slate-900 hover:text-white">
                <x-heroicon-s-home class="h-4 w-4 transition ease-in-out group-hover:fill-current group-hover:text-blue-500" />
                <span class="ml-2">{{ __('Home') }}</span>
              </li>

              <!-- company -->
              <li class="group flex items-center px-4 py-2 hover:bg-slate-900 hover:text-white">
                <x-heroicon-s-building-office class="h-4 w-4 transition ease-in-out group-hover:fill-current group-hover:text-blue-500" />
                <span class="ml-2">{{ $user['organization'] }}</span>
              </li>

              <!-- projects -->
              <li class="group flex items-center px-4 py-2 hover:bg-slate-900 hover:text-white">
                <x-heroicon-s-briefcase class="h-4 w-4 transition ease-in-out group-hover:fill-current group-hover:text-blue-500" />
                <span class="ml-2">
                  <a href="{{ route('project.index') }}" wire:navigate>{{ __('Projects') }}</a>
                </span>
              </li>

              <!-- asset management -->
              <li class="group flex items-center px-4 py-2 hover:bg-slate-900 hover:text-white">
                <x-heroicon-s-computer-desktop class="h-4 w-4 transition ease-in-out group-hover:fill-current group-hover:text-blue-500" />
                <span class="ml-2">{{ __('Asset management') }}</span>
              </li>

              <!-- settings -->
              @if ($user['can_manage_settings'])
                <li class="group flex items-center px-4 py-2 hover:bg-slate-900 hover:text-white" v-if="user.permissions !== 'user'">
                  <x-heroicon-s-cog-8-tooth class="h-4 w-4 transition ease-in-out group-hover:fill-current group-hover:text-blue-500" />
                  <span class="ml-2">
                    <a href="{{ route('settings.index') }}" wire:navigate.hover>{{ __('Account settings') }}</a>
                  </span>
                </li>
              @endif
            </ul>

            <!-- help and user -->
            <ul class="mb-4 border-b border-slate-700 pb-4 text-slate-400">
              <li class="group flex items-center px-4 py-2 hover:bg-slate-900 hover:text-white">
                <x-heroicon-s-question-mark-circle class="h-4 w-4 transition ease-in-out group-hover:fill-current group-hover:text-blue-500" />
                <span class="ml-2">{{ __('Help') }}</span>
              </li>

              <li class="group flex items-center px-4 py-2 hover:bg-slate-900 hover:text-white">
                <x-heroicon-s-arrow-left-on-rectangle class="h-4 w-4 transition ease-in-out group-hover:fill-current group-hover:text-blue-500" />

                <form class="ml-2" method="POST" action="{{ route('logout') }}">
                  @csrf
                  <span class="cursor-pointer" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Logout') }}</span>
                </form>
              </li>
            </ul>

            <!-- user -->
            <ul class="mb-4 text-slate-400">
              <li class="group flex items-center px-4 py-2 hover:bg-slate-900 hover:text-white">
                <div class="mr-2 h-7 w-7 rounded">
                  {!! $user['avatar']['content'] !!}
                </div>
                <span class="ml-2">
                  <a href="">{{ $user['name'] }}</a>
                </span>
              </li>
            </ul>

            <!-- language selector -->
            @include('layouts.language-selector')
          </div>
        </nav>
      </div>
    </div>

    <script type="text/javascript">
      e = document.querySelector("div.notify");
      if (e) {
        setTimeout(function() {
          e.style.display = 'none'
        }, 3000);
      }
    </script>
  </body>

</html>
