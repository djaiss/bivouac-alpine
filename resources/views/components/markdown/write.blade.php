<div id="markdown" class="w-full">
  @csrf
  @method('POST')

  <input name="placeholder" type="hidden" value="{{ $placeholder }}">
  <input name="class" type="hidden" value="{{ $class }}">

  <ul class="mb-5 inline-block text-sm">
    <li class="border-blue-600 text-blue-600 inline cursor-pointer rounded-l-md border px-3 py-1 pr-2 hover:border-blue-600 hover:text-blue-600">
      {{ __('Write') }}
    </li>
    <li hx-target="#markdown"
      hx-post="{{ route('markdown.preview') }}"
      hx-swap="outerHTML"
      class="border-blue-600 text-blue-600 inline cursor-pointer rounded-r-md border-b border-r border-t px-3 py-1 hover:border-blue-600 hover:text-blue-600">
      {{ __('Preview') }}
    </li>
  </ul>

  <textarea type="text"
            x-data="{
                resize() {
                    $el.style.height = '0px';
                    $el.style.height = $el.scrollHeight + 'px'
                }
            }"
            x-init="resize()"
            @input="resize()"
            id="body"
            name="body"
            placeholder="{{ $placeholder }}"
            required
            class="{{ $class }}">{{ $body }}</textarea>
</div>
