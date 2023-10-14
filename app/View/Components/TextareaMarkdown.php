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
        public string $body,
        public string $placeholder,
    )
    {
        $this->placeholder = $placeholder ?? __('Write something...');
    }

    public function render(): View|Closure|string
    {
        return view('components.textarea-markdown');
    }
}
