@props(['contentClasses' => 'py-1 bg-white dark:bg-gray-700'])

<div class="flex items-center">
  <div class="relative mr-2"
       style="top: 2px;"
       x-data="{ open: false }"
       @click.outside="open = false"
       @close.stop="open = false">

    <div class="inline-block rounded-full bg-gray-200 p-1 hover:cursor-pointer hover:bg-lime-200" @click="open = ! open">
      <x-heroicon-o-face-smile class="w-4" />
    </div>

    <div class="absolute left-0 z-50 mt-2 origin-top-left rounded-md shadow-lg"
         style="display: none;"
         x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click="open = false">
      <div class="{{ $contentClasses }} rounded-md ring-1 ring-black ring-opacity-5">
        <div class="flex p-2">
          <div class="mr-1 cursor-pointer rounded-lg bg-gray-200 px-2 py-1 hover:bg-gray-300" wire:click="save('👍')">
            👍
          </div>
          <div class="mr-1 cursor-pointer rounded-lg bg-gray-200 px-2 py-1 hover:bg-gray-300" wire:click="save('👎')">
            👎
          </div>
          <div class="mr-1 cursor-pointer rounded-lg bg-gray-200 px-2 py-1 hover:bg-gray-300" wire:click="save('😁')">
            😁
          </div>
          <div class="mr-1 cursor-pointer rounded-lg bg-gray-200 px-2 py-1 hover:bg-gray-300" wire:click="save('🎉')">
            🎉
          </div>
          <div class="mr-1 cursor-pointer rounded-lg bg-gray-200 px-2 py-1 hover:bg-gray-300" wire:click="save('🫤')">
            🫤
          </div>
          <div class="mr-1 cursor-pointer rounded-lg bg-gray-200 px-2 py-1 hover:bg-gray-300" wire:click="save('😭')">
            😭
          </div>
          <div class="mr-1 cursor-pointer rounded-lg bg-gray-200 px-2 py-1 hover:bg-gray-300" wire:click="save('❤️')">
            ❤️
          </div>
          <div class="cursor-pointer rounded-lg bg-gray-200 px-2 py-1 hover:bg-gray-300" wire:click="save('🚀')">🚀</div>
        </div>
      </div>
    </div>
  </div>

  <!-- list of existing reactions -->
  @if ($reactions->count() > 0)
    <div class="flex items-center">
      @foreach ($reactions as $reaction)
        <div wire:key="{{ $reaction['id'] }}" @if ($reaction['author']['id'] === auth()->user()->id) class="mr-2 flex rounded-lg px-1 py-1 cursor-pointer border border-yellow-200 bg-yellow-100"
      wire:click="destroy({{ $reaction['id'] }})"
      @else
      class="mr-2 flex rounded-lg px-1 py-1 border border-gray-300" @endif>
          <x-avatar class="mr-2 h-6 w-6 rounded" :data="$reaction['author']['avatar']" />

          <span>{{ $reaction['emoji'] }}</span>
        </div>
      @endforeach
    </div>
  @endif
</div>
