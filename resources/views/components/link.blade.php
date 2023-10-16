@props(['disableBoost' => false])

@if ($disableBoost)
  <a {{ $attributes->merge(['class' => 'text-blue-700 underline hover:bg-blue-700 hover:text-white transition duration-200']) }}>
    {{ $slot }}
  </a>
@else
<a hx-boost="true" {{ $attributes->merge(['class' => 'text-blue-700 underline hover:bg-blue-700 hover:text-white transition duration-200']) }}>
  {{ $slot }}
</a>
@endif
