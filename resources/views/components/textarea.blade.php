@props(['placeholder' => ''])

<div class="w-full">
  <textarea type="text"
            x-data="{
                resize() {
                    $el.style.height = '0px';
                    $el.style.height = $el.scrollHeight + 'px'
                }
            }"
            x-init="resize()"
            @input="resize()"
            placeholder="{{ $placeholder }}"
            {!! $attributes->merge([
                'class' =>
                    'h-auto min-h-[80px] px-3 py-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 placeholder:text-neutral-400 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
            ]) !!}>{{ $slot }}</textarea>
</div>