<div id="markdown" class="w-full">
  @csrf
  @method('POST')

  <ul class="mb-5 inline-block text-sm">
    <li hx-target="#markdown" hx-post="{{ route('markdown.write') }}" class="border-blue-600 text-blue-600 inline cursor-pointer rounded-l-md border px-3 py-1 pr-2 hover:border-blue-600 hover:text-blue-600">
      {{ __('Write') }}
    </li>
    <li class="border-blue-600 text-blue-600 inline cursor-pointer rounded-r-md border-b border-r border-t px-3 py-1 hover:border-blue-600 hover:text-blue-600">
      {{ __('Preview') }}
    </li>
  </ul>

  <div class="w-full rounded-lg border bg-gray-50 p-4">
    @if ($preview !== '')
      <div class="prose">{!! $preview !!}</div>
    @else
      <p class="text-center text-gray-500">{{ __('There is nothing to preview') }}</p>
    @endif
  </div>
</div>
