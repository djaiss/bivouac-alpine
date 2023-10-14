@props(['placeholder' => '', 'minHeight' => 'min-h-[80px]'])

<div id="markdown" class="w-full">
  @csrf
  @method('POST')

  <ul class="mb-5 inline-block text-sm">
    <li class="border-blue-600 text-blue-600 inline cursor-pointer rounded-l-md border px-3 py-1 pr-2 hover:border-blue-600 hover:text-blue-600">
      {{ __('Write') }}
    </li>
    <li hx-target="#markdown" hx-post="{{ route('markdown.preview') }}" class="border-blue-600 text-blue-600 inline cursor-pointer rounded-r-md border-b border-r border-t px-3 py-1 hover:border-blue-600 hover:text-blue-600">
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
            {!! $attributes->merge([
                'class' => $minHeight . ' h-auto px-3 py-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 placeholder:text-neutral-400 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
            ]) !!}>{{ $preview }}</textarea>
</div>
