@props(['data', 'url' => null])

@if ($url)
  <a :href="url">
    @if ($data['type'] === 'svg')
      <div {{ $attributes->merge(['class' => 'mr-2 rounded']) }}>
        {!! $data['content'] !!}
      </div>
    @else
      <img src="{{ $data['content'] }}"
           alt="avatar"
           {{ $attributes->merge(['class' => 'mr-2 rounded']) }} />
    @endif
  </a>
@else
  <div>
    @if ($data['type'] === 'svg')
      <div {{ $attributes->merge(['class' => 'mr-2 rounded']) }}>
        {!! $data['content'] !!}
      </div>
    @else
      <img src="{{ $data['content'] }}"
           alt="avatar"
           {{ $attributes->merge(['class' => 'mr-2 rounded']) }} />
    @endif
  </div>
@endif
