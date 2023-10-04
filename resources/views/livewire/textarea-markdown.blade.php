<div>
  <!-- toggle mode -->
  <ul class="mb-5 inline-block text-sm">
    <li class="{{ $activeTab === 'write' ? 'border-blue-600 text-blue-600' : '' }} inline cursor-pointer rounded-l-md border px-3 py-1 pr-2 hover:border-blue-600 hover:text-blue-600" wire:click="toggle('write')">
      {{ __('Write') }}
    </li>
    <li class="{{ $activeTab === 'preview' ? 'border-blue-600 text-blue-600 border-l' : '' }} inline cursor-pointer rounded-r-md border-b border-r border-t px-3 py-1 hover:border-blue-600 hover:text-blue-600" wire:click="toggle('preview')">
      {{ __('Preview') }}
    </li>
  </ul>

  <!-- write mode -->
  @if ($activeTab === 'write')

    <div>
      <x-textarea class="block w-full"
                  id="body"
                  name="body"
                  type="text"
                  wire:model="body"
                  required
                  :minHeight="$minHeight"
                  :value="old('body')" />

      <x-input-error class="mt-2" :messages="$errors->get('body')" />
    </div>
  @else
    <!-- preview mode -->
    <div class="w-full rounded-lg border bg-gray-50 p-4">
      @if ($previewBody !== '')
        <div class="prose">{!! $previewBody !!}</div>
      @else
        <p class="text-center text-gray-500">{{ __('There is nothing to preview') }}</p>
      @endif
    </div>

  @endif
</div>
