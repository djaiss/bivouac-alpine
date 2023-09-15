<x-app-layout>
  <div class="mx-auto mb-6 max-w-7xl space-y-6 px-12 pt-6 sm:px-6 lg:px-8">
    <!-- project header -->
    <x-project.header :data="$header" />

    <!-- body -->
    <div class="grid grid-cols-[2fr_1fr] gap-4">
      <!-- left -->
      <div>
        <!-- detailed description-->
        <div class="mb-6 bg-white px-4 py-4 shadow sm:rounded-lg">
          <p class="mb-4 text-sm font-bold">{{ __('Detailed description') }}</p>

          @if ($view['description'])
            <!-- description, if it exists -->
            <div class="prose">{!! $view['description'] !!}</div>
          @else
            <!-- no description -->
            <div class="text-gray-400">
              {{ __('No details yet. Consider adding some under the Settings tab.') }}
            </div>
          @endif
        </div>

        <!-- key resources -->
        <div class="mb-6 bg-white px-4 py-4 shadow sm:rounded-lg"
             x-data="{ open: false, label: '', link: '' }">
          <p class="mb-4 text-sm font-bold">{{ __('Key resources') }}</p>

          <livewire:projects.manage-key-resources :data="$view" />
        </div>
      </div>

      <!-- right -->
      <div class="bg-white shadow sm:rounded-lg"></div>
    </div>
  </div>
</x-app-layout>
