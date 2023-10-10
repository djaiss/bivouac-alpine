<x-app-layout>
  <div class="mx-auto mb-6 max-w-7xl space-y-6 px-12 pt-6 sm:px-6 lg:px-8">
    <!-- project header -->
    <x-project.header :data="$header" />

    <!-- help -->
    <div class="mx-auto flex max-w-2xl bg-white px-4 py-2 text-sm shadow sm:rounded-lg">
      <x-heroicon-o-question-mark-circle class="h-6 w-6 shrink-0 pe-2 text-gray-600" />
      <p>
        {{ __('If the project is public, anyone can take part without having to be a formal member. On the other hand, private projects are only accessible and open to members.') }}
      </p>
    </div>

    <livewire:projects.manage-project-members :data="$view" />
  </div>
</x-app-layout>
