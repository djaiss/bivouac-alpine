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
              <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Manage offices') }}</span>
            </div>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="mx-auto flex max-w-4xl pb-12 sm:px-6 lg:px-8">
    <div class="w-full">
      <div class="bg-white shadow sm:rounded-lg">
        <!-- title -->
        <div class="flex items-center justify-between border-b border-gray-200 px-4 py-2">
          <h2 class="text-lg font-medium text-gray-900">
            {{ __('All the organization\'s offices') }}
          </h2>

          <div>
            <x-primary-link :href="route('settings.office.create')">{{ __('Add an office') }}</x-primary-link>
          </div>
        </div>

        <!-- list of offices -->
        <ul class="w-full">
          @foreach ($view['offices'] as $office)
            <li class="group flex items-center justify-between px-6 py-4 hover:bg-slate-100 last:hover:rounded-b-lg">

              <div class="flex items-center">
                <span class="mr-3">{{ $office['name'] }}</span>

                @if ($office['is_main_office'])
                  <span class="flex items-center rounded-lg border border-lime-300 bg-lime-50 px-2 py-1 text-xs">
                    <span class="text-lime-600">{{ __('main office') }}</span>
                  </span>
                @endif
              </div>

              <!-- menu -->
              <ul>
                <li class="mr-2 inline"><x-link class="text-sm" href="{{ route('settings.office.edit', ['office' => $office['id']]) }}">{{ __('Edit') }}</x-link>
                </li>
                <li class="inline"><x-link class="text-sm" href="{{ route('settings.office.delete', ['office' => $office['id']]) }}">{{ __('Delete') }}</x-link>
                </li>
              </ul>
            </li>
          @endforeach
        </ul>

        <!-- blank state -->
        @if (count($view['offices']) === 0)
          <div class="px-4 py-6 text-center">
            <h3 class="mb-2 text-lg font-medium text-gray-900">{{ __("You haven't set an office yet.") }}</h3>
            <p class="mb-20 text-gray-500">{{ __('Get started by adding your first office.') }}</p>
            <img class="mx-auto block h-60 w-60" src="/img/offices.png" alt="" />
          </div>
        @endif
      </div>
    </div>
  </div>

</x-app-layout>
