<div hx-target="#resources">
  <ul class="mb-2" id="resources">
    @foreach ($view['project_resources'] as $projectResource)
    <li id="resource-{{ $projectResource['id'] }}" class="group mb-1 flex items-center justify-between rounded-lg border border-transparent px-2 py-1 hover:border-sky-300 hover:bg-sky-50">
      <div class="flex items-center">
        <x-heroicon-s-link class="mr-2 h-4 w-4 text-blue-400 group-hover:text-blue-700" />
        <a class="text-blue-700 underline hover:rounded-sm hover:bg-blue-700 hover:text-white" href="{{ $projectResource['link'] }}">
          @if ($projectResource['label'])
            {{ $projectResource['label'] }}
          @else
            {{ $projectResource['link'] }}
          @endif
        </a>
      </div>

      <div class="flex">
        <x-heroicon-s-pencil-square
          hx-get="{{ $projectResource['url']['edit'] }}"
          hx-target="#resource-{{ $projectResource['id'] }}"
          class="mr-2 hidden h-5 w-5 cursor-pointer rounded text-gray-400 hover:bg-gray-300 hover:text-gray-600 group-hover:block"
        />

        <x-heroicon-s-x-mark
          hx-delete="{{ $projectResource['url']['destroy'] }}"
          hx-confirm="{{ __('Are you sure you want to delete this resource?' )}}"
          hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
          class="hidden h-5 w-5 cursor-pointer rounded text-gray-400 hover:bg-gray-300 hover:text-gray-600 group-hover:block"
        />
      </div>
    </li>
    @endforeach
  </ul>
</div>

<div hx-target="this" hx-get="{{ $view['url']['resource']['create'] }}">
  <span class="mr-2 cursor-pointer rounded border border-dashed border-gray-300 bg-gray-50 px-2 py-1 text-sm hover:border-gray-400 hover:bg-gray-200">{{ __('Add resource') }}</span>
</div>
