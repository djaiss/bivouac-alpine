<div>
  <!-- toggle mode -->
  <ul v-if="form.body" class="mb-5 inline-block text-sm">
    <li
      wire:click="toggle('write')"
      class="inline cursor-pointer rounded-l-md border px-3 py-1 pr-2 hover:border-blue-600 hover:text-blue-600 {{ $activeTab === 'write' ? 'border-blue-600 text-blue-600' : '' }}">
      {{ __('Write') }}
    </li>
    <li
      wire:click="toggle('preview')"
      class="inline cursor-pointer rounded-r-md border-b border-r border-t px-3 py-1 hover:border-blue-600 hover:text-blue-600 {{ $activeTab === 'preview' ? 'border-blue-600 text-blue-600' : '' }}">
      {{ __('Preview') }}
    </li>
  </ul>

  <!-- write mode -->
  @if ($activeTab === 'write')

  <div>
    <x-textarea class="block w-full"
      id="body"
      wire:model="body"
      name="body"
      type="text"
      required
      :minHeight="'min-h-[400px]'"
      :value="old('body')" />
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
