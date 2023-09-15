<div x-data="{ open: false, label: '', link: '' }">
  <ul class="mb-2"
      id="resources">
    @foreach ($resources as $projectResource)
      <!-- not in edit mode -->
      @if ($editedResourceId !== $projectResource['id'])
        <li class="group mb-3 flex items-center justify-between rounded-lg px-2 py-1 hover:bg-sky-50"
            wire:key="{{ $projectResource['id'] }}">
          <div class="flex items-center">
            <x-heroicon-s-link class="mr-2 h-4 w-4 text-blue-400 group-hover:text-blue-700" />
            <a class="text-blue-700 underline hover:rounded-sm hover:bg-blue-700 hover:text-white"
               href="{{ $projectResource['link'] }}">
              @if ($projectResource['label'])
                {{ $projectResource['label'] }}
              @else
                {{ $projectResource['link'] }}
              @endif
            </a>
          </div>

          <div class="flex">
            <x-heroicon-s-pencil-square class="mr-2 hidden h-5 w-5 cursor-pointer rounded text-gray-400 hover:bg-gray-300 hover:text-gray-600 group-hover:block"
                                        wire:click="toggleEdit({{ $projectResource['id'] }})" />

            <x-heroicon-s-x-mark class="hidden h-5 w-5 cursor-pointer rounded text-gray-400 hover:bg-gray-300 hover:text-gray-600 group-hover:block"
                                 wire:click="destroy({{ $projectResource['id'] }})" />
          </div>
        </li>
      @endif

      <!-- edit mode -->
      @if ($editedResourceId === $projectResource['id'])
        <li class="group mb-3 flex items-center justify-between rounded-lg px-2 py-1 hover:bg-sky-50"
            wire:key="{{ $projectResource['id'] }}">
          <form class="flex items-end justify-between"
                wire:submit="update({{ $projectResource['id'] }})">
            <div class="mr-2 flex w-full">
              <!-- label -->
              <div class="mr-2 w-full">
                <x-input-label class="mb-1"
                               for="label"
                               :optional="true"
                               :value="__('Label')" />

                <x-text-input class="block w-full"
                              id="label"
                              name="label"
                              type="text"
                              wire:model="label"
                              wire:keydown.escape="toggleEdit()"
                              :value="old('label')" />

                <x-input-error class="mt-2"
                               :messages="$errors->get('label')" />
              </div>

              <!-- link -->
              <div class="w-full">
                <x-input-label class="mb-1"
                               for="link"
                               :value="__('URL/link')" />

                <x-text-input class="block w-full"
                              id="link"
                              name="link"
                              type="text"
                              wire:model="link"
                              wire:keydown.escape="toggleEdit()"
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

              <span class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200"
                    wire:click="toggleEdit()">
                {{ __('Cancel') }}
              </span>
            </div>
          </form>
        </li>
      @endif
    @endforeach
  </ul>

  @if (!$showAddModal)
    <div>
      <span class="mr-2 cursor-pointer rounded border border-dashed border-gray-300 bg-gray-50 px-2 py-1 text-sm hover:border-gray-400 hover:bg-gray-200"
            wire:click="toggle">
        {{ __('Add resource') }}
      </span>
    </div>
  @endif

  <!-- add a new resource -->
  @if ($showAddModal)
    <form class="flex items-end justify-between"
          wire:submit="save">
      <div class="mr-2 flex w-full">
        <!-- label -->
        <div class="mr-2 w-full">
          <x-input-label class="mb-1"
                         for="label"
                         :optional="true"
                         :value="__('Label')" />

          <x-text-input class="block w-full"
                        id="label"
                        name="label"
                        type="text"
                        wire:model="label"
                        wire:keydown.escape="toggle"
                        :value="old('label')" />

          <x-input-error class="mt-2"
                         :messages="$errors->get('label')" />
        </div>

        <!-- link -->
        <div class="w-full">
          <x-input-label class="mb-1"
                         for="link"
                         :value="__('URL/link')" />

          <x-text-input class="block w-full"
                        id="link"
                        name="link"
                        type="text"
                        wire:model="link"
                        wire:keydown.escape="toggle"
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

        <span class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200"
              wire:click="toggle">
          {{ __('Cancel') }}
        </span>
      </div>
    </form>
  @endif
</div>

<script>
  document.addEventListener('livewire:initialized', () => {
    @this.on('focus-label-field', (event) => {
      document.querySelector('.label').focus();
    });
  });
</script>
