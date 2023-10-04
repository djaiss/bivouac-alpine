<div class="rounded-lg bg-white shadow">
  <!-- title of the task list -->
  <div class="{{ !$collapsed ? 'border-b' : '' }} flex items-center justify-between px-4 py-2">

    <!-- section title -->
    @if ($taskList['name'])

      <p class="font-bold">{{ $taskList['name'] }}</p>
    @else
      <div>
        @if ($context === 'message')
          <p>{{ __('Tasks') }}</p>
        @else
          <x-link class="text-blue-700 underline hover:rounded-sm hover:bg-blue-700 hover:text-white"
                  href="{{ $taskList['parent']['url'] }}">
            {{ $taskList['parent']['title'] }}
          </x-link>
        @endif
      </div>

    @endif

    <!-- progress and cta -->
    <div class="flex items-center">
      <!-- completion -->
      {{-- <div :key="componentKey" v-tooltip="__('Completion rate')" class="mr-4 h-2 w-24 rounded-full bg-blue-200">
        <div
          class="h-full rounded-full bg-blue-600 text-center text-xs text-white"
          :style="'width: ' + completionRate + '%'"></div>
      </div>
      <ConfettiExplosion v-if="visibleConfetti" /> --}}

      <div class="flex items-center">
        <!-- button -->
        <p class="mr-2 cursor-pointer rounded-lg border border-dashed border-gray-300 bg-gray-50 px-3 py-1 text-sm hover:border-gray-400 hover:bg-gray-200"
           wire:click="toggleAddModal()">
          {{ __('Add task') }}
        </p>

        <!-- collapse toggle -->
        @if ($collapsed)
          <div class="cursor-pointer rounded-lg px-1 py-1.5 text-gray-400 hover:bg-gray-100"
               wire:click="toggle()">
            <x-heroicon-o-chevron-up class="h-5 w-5" />
          </div>
        @else
          <div class="cursor-pointer rounded-lg px-1 py-1.5 text-gray-400 hover:bg-gray-100"
               wire:click="toggle()">
            <x-heroicon-o-chevron-down class="h-5 w-5" />
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- tasks in the list -->
  @if (!$collapsed)
    <div class="rounded-b-lg bg-gray-50">
      <!-- list of tasks -->
      @if (count($tasks))
        @foreach ($tasks as $task)
          <div class="border-b px-4 py-2 last:border-b-0"
               wire:key="{{ $task['id'] }}">
            <div x-data="{
                isEditing: false,
                title: '{{ $task['title'] }}',
                focus: function() {
                    const textInput = this.$refs.textInput;
                    textInput.focus();
                    textInput.select();
                }
            }"
                 x-cloak>
              <!-- content of the task -->
              <div
                   class="relative flex w-full items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border hover:border-gray-200 hover:bg-white">
                <!-- title and checkbox -->
                <div class="flex items-center"
                     x-show="!isEditing">

                  <input class="mr-2 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                         type="checkbox"
                         {{ $task['is_completed'] ? 'checked="checked"' : '' }}
                         wire:click="checkTask({{ $task['id'] }})">

                  <span>{{ $task['title'] }}</span>
                </div>

                <!-- options and assignees -->
                <div class="flex items-center"
                     x-show="!isEditing">
                  <!-- assignees -->
                  @if (count($task['assignees']) > 0)
                    <div class="flex -space-x-3">
                      @foreach ($task['assignees'] as $assignee)
                        <x-avatar class="h-6 w-6 cursor-pointer rounded-full border-2 border-white dark:border-gray-800"
                                  :data="$assignee['avatar']" />
                      @endforeach
                    </div>
                  @endif

                  <!-- options -->
                  <div class="relative"
                       x-data="{ dropdownOpen: false }">
                    <button class="inline-flex items-center justify-center rounded-md border-gray-100 px-3 py-2 text-sm font-medium text-neutral-700 transition-colors hover:border-gray-400 hover:bg-white focus:outline-none disabled:pointer-events-none disabled:opacity-50"
                            @click="dropdownOpen=true">
                      <x-heroicon-o-ellipsis-horizontal class="h-5 w-5 text-gray-500 hover:text-gray-700" />
                    </button>

                    <div class="absolute left-1/2 top-0 z-50 mt-8 w-56 -translate-x-1/2"
                         x-show="dropdownOpen"
                         @click.away="dropdownOpen=false"
                         x-transition:enter="ease-out duration-200"
                         x-transition:enter-start="-translate-y-2"
                         x-transition:enter-end="translate-y-0"
                         x-cloak>
                      <div class="mt-1 rounded-md border border-neutral-200/70 bg-white p-1 text-neutral-700 shadow-md">
                        <span class="relative flex cursor-pointer select-none items-center rounded px-2 py-1.5 text-sm outline-none transition-colors hover:bg-neutral-100 data-[disabled]:pointer-events-none data-[disabled]:opacity-50"
                              x-on:click="isEditing = true; $nextTick(() => focus()); dropdownOpen=false">
                          <x-heroicon-o-pencil class="mr-2 h-4 w-4" />
                          <span>{{ __('Edit') }}</span>
                        </span>
                        <a
                           class="relative flex cursor-pointer select-none items-center rounded px-2 py-1.5 text-sm outline-none transition-colors hover:bg-neutral-100 data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                          <x-heroicon-o-trash class="mr-2 h-4 w-4" />
                          <span>{{ __('Delete') }}</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- edit a task -->
              <form class="flex items-center justify-between"
                    x-show="isEditing"
                    wire:submit="update({{ $task['id'] }})">

                <x-text-input class="block w-full"
                              class="mr-3 w-full"
                              id="title"
                              name="title"
                              type="text"
                              wire:model="title"
                              x-model="title"
                              x-ref="textInput"
                              required
                              x-on:keydown.escape="isEditing = false"
                              :value="old('title')" />

                <!-- actions -->
                <div class="flex items-center">
                  <x-primary-button class="mr-2"
                                    x-on:click="isEditing = false">
                    {{ __('Save') }}
                  </x-primary-button>

                  <span class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200"
                        x-on:click="isEditing = false">
                    {{ __('Cancel') }}
                  </span>
                </div>
              </form>
            </div>
          </div>
        @endforeach
      @endif

      <!-- blank state -->
      @if (count($tasks) == 0 && !$showAddTaskModal)
        <p class="px-4 py-2 text-sm">
          {{ __('Use tasks to iterate on something that is essential to achieve.') }}
        </p>
      @endif

      <!-- add task -->
      @if ($showAddTaskModal)
        <div class="px-4 py-2">
          <form class="flex items-center justify-between"
                wire:submit="save()">
            <x-text-input class="block w-full"
                          class="mr-3 w-full"
                          id="title"
                          name="title"
                          type="text"
                          wire:model="title"
                          autofocus
                          wire:keydown.escape="toggleAddModal()"
                          :value="old('title')" />

            <!-- actions -->
            <div class="flex items-center">
              <x-primary-button class="mr-2">
                {{ __('Save') }}
              </x-primary-button>

              <span class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200"
                    wire:click="toggleAddModal()">
                {{ __('Cancel') }}
              </span>
            </div>
          </form>
        </div>
      @endif
    </div>
  @endif
</div>
