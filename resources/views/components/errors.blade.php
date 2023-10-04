@if ($errors->any())
  <div {{ $attributes->merge(['class' => 'border-red flex items-center rounded border p-3']) }}>
    <img class="h-24 w-24" src="img/error.png" alt="lumberjack being embarrassed" />

    <div>
      <p class="mb-2 text-sm">{{ __("We've found some errors.") }}</p>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif
