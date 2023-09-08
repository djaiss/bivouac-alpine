@props(['value', 'optional' => false])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
  {{ $value ?? $slot }}

  @if ($optional)
    <span class="optional-badge ml-2 rounded px-[3px] py-px text-xs">{{ __('optional') }}</span>
  @endif
</label>
