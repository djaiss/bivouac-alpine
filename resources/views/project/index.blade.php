<x-app-layout>
  <div class="mx-auto mb-6 max-w-7xl space-y-6 px-12 pt-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg">
      <!-- menu -->
      <div class="px-4">
        <div class="flex items-center justify-between text-center font-medium text-gray-500 dark:text-gray-400">
          <ul class="-mb-px flex flex-wrap">
            <li class="mr-2">
              <a class="inline-block rounded-t-lg border-b-2 border-transparent p-4 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300"
                 href="#">
                {{ __('Your projects') }}
              </a>
            </li>
            <li class="mr-2">
              <a class="active inline-block rounded-t-lg border-b-2 border-blue-600 p-4 text-blue-600 dark:border-blue-500 dark:text-blue-500"
                 href="#">
                {{ __('Starred projects') }}
              </a>
            </li>
            <li class="mr-2">
              <a class="inline-block rounded-t-lg border-b-2 border-transparent p-4 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300"
                 href="#">
                {{ __('All projects') }}
              </a>
            </li>
          </ul>

          <div>
            <x-primary-link wire:navigate
                            :href="route('project.create')">{{ __('Create project') }}</x-primary-link>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="pb-12">
    <div class="mx-auto flex max-w-5xl sm:px-6 lg:px-8">
      <div class="w-full">
        <div class="bg-white shadow sm:rounded-lg">
          <!-- list of projects -->
          <div class="flex">
            <ul class="w-full">
              @foreach ($view['projects'] as $project)
                <li
                    class="border-b px-6 py-4 last:border-b-0 hover:bg-slate-50 first:hover:rounded-t-lg last:hover:rounded-b-lg">
                  <!-- project information -->
                  <div class="flex items-center justify-between">
                    <div class="mr-6 flex flex-col">
                      <!-- project name -->
                      <div class="flex items-center">
                        @if ($project['is_public'])
                          <x-icon-lock />
                        @endif

                        <x-link href="{{ route('project.show', ['project' => $project['id']]) }}"
                                wire:navigate>
                          {{ $project['name'] }}
                        </x-link>
                      </div>

                      <!-- description & last activity -->
                      <div class="mt-2 flex items-center">
                        @if ($project['short_description'])
                          <p class="mr-4 text-sm text-gray-600">
                            {{ $project['short_description'] }}
                          </p>
                        @endif

                        <div class="flex">
                          <svg class="mr-1 w-6"
                               viewBox="0 0 201 127"
                               fill="none"
                               xmlns="http://www.w3.org/2000/svg">
                            <path d="M72.7119 0.403809L69.8206 8.5089L49.9031 63.3197C28.0589 63.294 23.4324 63.3197 0.27002 63.3197V68.4557C24.2563 68.4557 27.6834 68.43 51.67 68.4557H53.4369L54.0794 66.7706L71.7481 18.2997L95.4402 117.81L97.4482 126.396L100.339 118.05L126.601 41.6523L139.291 67.0112L140.014 68.4557H141.62H185.792C186.86 71.4302 189.676 73.5917 193.02 73.5917C197.278 73.5917 200.73 70.1426 200.73 65.8877C200.73 61.6327 197.278 58.1837 193.02 58.1837C189.676 58.1837 186.86 60.3451 185.792 63.3197H143.226L128.529 33.8679L125.799 28.4109L123.791 34.1889L98.4119 108.019L74.7198 8.74981L72.7119 0.403809Z"
                                  fill="#7A7A7A" />
                          </svg>
                          <div class="text-xs">{{ $project['updated_at'] }}</div>
                        </div>
                      </div>
                    </div>

                    <!-- contributors -->
                    <div class="flex -space-x-4">
                      @foreach ($project['members'] as $member)
                        <x-avatar class="mr-2 h-8 w-8 cursor-pointer rounded-full border-2 border-white"
                                  :data="$member['avatar']" />
                      @endforeach

                      @if ($project['other_members_counter'] > 0)
                        <div
                             class="flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-gray-700 text-xs font-medium text-white hover:bg-gray-600 dark:border-gray-800">
                          <span>+{{ $project['other_members_counter'] }}</span>
                        </div>
                      @endif
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>

          <!-- blank state -->
          @if (count($view['projects']) === 0)
            <div>
              <div class="px-4 py-6 text-center">
                <h3 class="mb-2 text-lg font-medium text-gray-900">{{ __("You haven't started a project yet.") }}</h3>
                <p class="mb-10 text-gray-500">{{ __('Get started by adding your first project.') }}</p>
                <img class="mx-auto block h-60 w-60"
                     src="/img/projects.png"
                     alt="projects" />
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
