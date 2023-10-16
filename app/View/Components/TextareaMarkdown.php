<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextareaMarkdown extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $body = '',
        public string $placeholder,
        public string $class,
    ) {
        $this->class = $class. ' h-auto px-3 py-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 placeholder:text-neutral-400 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm';
    }

    public function render(): View|Closure|string
    {
        return view('components.markdown.write');
    }
}
