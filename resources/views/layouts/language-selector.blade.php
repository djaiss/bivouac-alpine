<ul class="list mb-4 px-4 py-2 text-center">
  @foreach ($user['locales'] as $locale)
    <li class="mr-2 inline">
      @if ($user['current_locale'] !== $locale['shortCode'])
        <x-link class="text-sm text-white hover:bg-transparent"
                href="{{ $locale['url'] }}">{{ $locale['name'] }}</x-link>
      @else
        <span class="text-sm text-gray-500">{{ $locale['name'] }}</span>
      @endif
    </li>
  @endforeach
</ul>
