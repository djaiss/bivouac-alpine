<x-app-layout>
  <div class="mx-auto mb-6 max-w-7xl space-y-6 px-12 pt-6 sm:px-6 lg:px-8">
    <!-- project header -->
    <x-project.header :data="$header" />

    <div class="mx-auto max-w-2xl">
      <!-- header -->
      <div class="mx-auto mb-4 max-w-4xl bg-white shadow sm:rounded-lg">
        <div class="flex items-center justify-between px-4 py-2">
          <h2 class="text-lg font-medium text-gray-900">
            {{ __('All the tasks') }}
          </h2>

          <div>
            <x-primary-link wire:navigate.hover :href="route('project.tasklist.create', ['project' => $header['id']])">{{ __('Add a task list') }}</x-primary-link>
          </div>
        </div>
      </div>

      <!-- list of task lists -->
      <div class="mx-auto max-w-4xl">
        @if (count($view['task_lists']) > 0)

          <!-- task lists -->
          @foreach ($view['task_lists'] as $taskList)
            <div class="mb-4">
              <livewire:projects.manage-task-lists :taskList="$taskList" :context="'project'" />
            </div>
          @endforeach
        @else
          <!-- blank state -->
          <div class="bg-white px-4 py-6 text-center shadow sm:rounded-lg">
            <h3 class="mb-2 text-lg font-medium text-gray-900">{{ __('No task list has been created yet.') }}</h3>
            <p class="mb-5 text-gray-500">
              {{ __('Create a task list to begin tracking your tasks and assign them to the appropriate people.') }}
            </p>
            <img class="mx-auto block h-60 w-60" src="/img/messages.png" alt="" />
          </div>

        @endif
      </div>
    </div>
  </div>
</x-app-layout>
