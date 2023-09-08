<x-app-layout>
  <div class="mx-auto mb-6 mt-8 max-w-7xl space-y-6 px-12 sm:px-6 lg:px-8">
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
        <div x-data="{ open: false }" class="mb-6 bg-white px-4 py-4 shadow sm:rounded-lg">
          <p class="mb-4 text-sm font-bold">{{ __('Key resources') }}</p>

          <ul class="mb-2" id="resources">
          @if ($view['project_resources']->count() > 0)
            <x-project.project-resources :data="$view['project_resources']" />
          @endif
          </ul>

          <!-- cta to add resource-->
          <div x-show="! open">
            <span
              @click="open = true; $nextTick(() => { $refs.label.focus(); });"
              class="mr-2 cursor-pointer rounded-lg border border-dashed border-gray-300 bg-gray-50 px-3 py-1 text-sm hover:border-gray-400 hover:bg-gray-200">
              {{ __('Add resource') }}
            </span>
          </div>

          <!-- add resource -->
          <form x-show="open" x-trap="open" x-target="resources" @ajax:after="open = false" method="POST" action="{{ route('project.resource.store', ['project' => $header['id']]) }}" class="flex justify-between items-end">
            @csrf

            <div class="mr-2 flex w-full">
              <div class="mr-2 w-full">
                <x-input-label class="mb-1"
                              for="label"
                              :optional="true"
                              :value="__('Label')" />

                <x-text-input class="block w-full"
                              x-ref="label"
                              id="label"
                              name="label"
                              type="text"
                              :value="old('label')"
                              @keyup.escape="open = false" />

                <x-input-error class="mt-2"
                              :messages="$errors->get('label')" />
              </div>

              <div class=" w-full">
                <x-input-label class="mb-1"
                              for="link"
                              :value="__('URL/link')" />

                <x-text-input class="block w-full"
                              id="link"
                              name="link"
                              type="text"
                              @keyup.escape="open = false"
                              :value="old('link')"
                              required />

                <x-input-error class="mt-2"
                              :messages="$errors->get('link')" />
              </div>
            </div>

            <!-- actions -->
            <div class="flex items-center">
              <x-primary-button class="mr-2">
                {{ __('Save') }}
              </x-primary-button>

              <span
                @click="open = false"
                class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200">
                {{ __('Cancel') }}
              </span>
            </div>
          </form>
        </div>
      </div>

      <!-- right -->
      <div class="bg-white shadow sm:rounded-lg"></div>
    </div>
  </div>
</x-app-layout>
