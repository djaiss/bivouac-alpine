<ul class="list">
  @foreach ($layout['locales'] as $locale)
    <li class="mr-2 inline">
      @if ($layout['current_locale'] !== $locale['shortCode'])
        <x-link class="text-sm"
                :route="$locale['url']">{{ $locale['name'] }}</x-link>
      @else
        <span class="text-sm text-gray-500">{{ $locale['name'] }}</span>
      @endif
    </li>
  @endforeach
</ul>
