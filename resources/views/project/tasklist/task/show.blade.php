<x-app-layout>
  <div class="mx-auto mb-6 max-w-7xl space-y-6 px-12 pt-6 sm:px-6 lg:px-8">
    <!-- project header -->
    <x-project.header :data="$header" />

    <livewire:projects.manage-task :task="$view" />
  </div>
</x-app-layout>
