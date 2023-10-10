@props(['name', 'show' => false])

<div class="relative h-auto w-auto"
     x-data="{ modalOpen: false }"
     @keydown.escape.window="modalOpen = false"
     :class="{ 'z-40': modalOpen }">
  <x-danger-button @click.prevent="modalOpen=true">
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
           @click="modalOpen=false"></div>
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
          <x-secondary-button @click="modalOpen=false">
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
