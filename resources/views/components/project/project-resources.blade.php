@props(['data'])

@foreach ($data as $projectResource)
  <li class="group mb-3 flex items-center justify-between rounded-lg px-2 py-1 hover:bg-gray-100">
    <div class="flex items-center">
      <x-heroicon-s-link class="mr-2 h-4 w-4 text-blue-400" />
      <a class="text-blue-700 underline hover:rounded-sm hover:bg-blue-700 hover:text-white"
         href="{{ $projectResource['link'] }}">
        @if ($projectResource['name'])
          {{ $projectResource['name'] }}
        @else
          {{ $projectResource['link'] }}
        @endif
      </a>
    </div>

    <div class="flex">
      <x-heroicon-s-pencil-square
                                  class="mr-2 hidden h-5 w-5 cursor-pointer rounded text-gray-400 hover:bg-gray-300 hover:text-gray-600 group-hover:block" />
      <x-heroicon-s-x-mark
                           class="hidden h-5 w-5 cursor-pointer rounded text-gray-400 hover:bg-gray-300 hover:text-gray-600 group-hover:block" />
    </div>
  </li>
@endforeach
