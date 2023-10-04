<x-app-layout>
  <div class="mx-auto mb-6 max-w-7xl space-y-6 px-12 pt-6 sm:px-6 lg:px-8">
    <!-- project header -->
    <x-project.header :data="$header" />

    <!-- update project details -->
    <div class="bg-white shadow sm:rounded-lg">
      <section>
        <header class="w-full">
          <h2 class="border-b border-gray-200 px-4 py-2 text-lg font-medium text-gray-900">
            {{ __('Edit project') }}
          </h2>
        </header>

        <div class="flex">
          <!-- instructions -->
          <div class="mr-8 w-96 p-4 text-sm">
            {{ __("A project title is a concise phrase that identifies a project, providing a brief overview of its subject or purpose. A project description expands on the title and provides a more detailed explanation of the project's goals, objectives, scope, and expected outcomes.") }}
          </div>

          <div class="w-full p-4">
            <form class="max-w-5xl space-y-4" method="post" action="{{ route('project.update', ['project' => $view['id']]) }}">
              @csrf
              @method('PUT')

              <!-- name -->
              <div>
                <x-input-label class="mb-1" for="title" :value="__('What is the name of the project?')" />

                <x-text-input class="block w-full"
                              id="title"
                              name="title"
                              type="text"
                              :value="old('title', $view['name'])"
                              required
                              autofocus />

                <x-input-error class="mt-2" :messages="$errors->get('title')" />
              </div>

              <!-- short description -->
              <div>
                <x-input-label class="mb-1"
                               for="title"
                               :optional="true"
                               :value="__('Summarize the project in one line.')" />

                <x-text-input class="block w-full"
                              id="short_description"
                              name="short_description"
                              type="text"
                              :value="old('short_description', $view['short_description'])" />

                <x-input-error class="mt-2" :messages="$errors->get('short_description')" />
              </div>

              <!-- full description -->
              <div>
                <x-input-label class="mb-1"
                               for="description"
                               :optional="true"
                               :value="__('Project description')" />

                <x-textarea class="block w-full"
                            id="description"
                            name="description"
                            type="text">{{ old('description', $view['description']) }}</x-textarea>

                <x-input-error class="mt-2" :messages="$errors->get('description')" />
              </div>

              <div class="space-y-2">
                <div class="flex items-center gap-x-2">
                  <input class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                         id="hidden"
                         name="is_public"
                         type="radio"
                         value="true"
                         @checked(old('is_public', $view['is_public'])) />
                  <label class="block text-sm font-medium leading-6 text-gray-900" for="hidden">
                    {{ __('Public: everyone can see and participate') }}
                  </label>
                </div>
                <div class="flex items-center gap-x-2">
                  <input class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                         id="month_day"
                         name="is_public"
                         type="radio"
                         value="false"
                         @checked(old('is_public', !$view['is_public'])) />
                  <label class="block text-sm font-medium leading-6 text-gray-900" for="month_day">
                    {{ __('Private: only selected users can access this project') }}
                  </label>
                </div>

                <x-input-error class="mt-2" :messages="$errors->get('is_public')" />
              </div>

              <div>
                <x-primary-button>
                  {{ __('Save') }}
                </x-primary-button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>

    <!-- destroy project -->
    <div class="bg-white shadow sm:rounded-lg">
      <section>
        <header class="w-full">
          <h2 class="border-b border-gray-200 px-4 py-2 text-lg font-medium text-gray-900">
            {{ __('Delete project') }}
          </h2>
        </header>

        <div class="flex">
          <!-- instructions -->
          <div class="prose mr-8 w-96 p-4 text-sm">
            {{ __('Deleting the project is instantaneous. This will remove everything, including any files uploaded.') }}
          </div>

          <div class="w-full p-4">
            <div class="relative h-auto w-auto"
                 x-data="{ modalOpen: false }"
                 @keydown.escape.window="modalOpen = false"
                 :class="{ 'z-40': modalOpen }">

              <x-danger-button @click.prevent="modalOpen = true">
                {{ __('Delete project') }}
              </x-danger-button>

              <template x-teleport="body">
                <div class="fixed left-0 top-0 z-[99] flex h-screen w-screen items-center justify-center" x-show="modalOpen" x-cloak>
                  <div class="absolute inset-0 h-full w-full bg-white bg-opacity-70 backdrop-blur-sm"
                       x-show="modalOpen"
                       x-transition:enter="ease-out duration-300"
                       x-transition:enter-start="opacity-0"
                       x-transition:enter-end="opacity-100"
                       x-transition:leave="ease-in duration-300"
                       x-transition:leave-start="opacity-100"
                       x-transition:leave-end="opacity-0"
                       @click="modalOpen = false"></div>
                  <div class="relative w-full border border-neutral-200 bg-white px-7 py-6 shadow-lg sm:max-w-lg sm:rounded-lg"
                       x-show="modalOpen"
                       x-trap.inert.noscroll="modalOpen"
                       x-transition:enter="ease-out duration-300"
                       x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95"
                       x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                       x-transition:leave="ease-in duration-200"
                       x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                       x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95">
                    <div class="flex items-center justify-between pb-3">
                      <h3 class="text-lg font-semibold">{{ __('Are you sure you want to delete this project?') }}</h3>
                    </div>
                    <div class="relative w-auto pb-8">
                      <p>
                        {{ __('Once the project is deleted, all of its resources and data will be permanently deleted.') }}
                      </p>
                    </div>
                    <form class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2" method="post" action="{{ route('project.destroy', ['project' => $view['id']]) }}">
                      @csrf
                      @method('delete')
                      <x-secondary-button @click="modalOpen = false">
                        {{ __('Cancel') }}
                      </x-secondary-button>

                      <x-danger-button class="ml-3">
                        {{ __('Delete') }}
                      </x-danger-button>
                    </form>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</x-app-layout>
