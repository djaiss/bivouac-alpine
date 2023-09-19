<?php

namespace App\Livewire;

use App\Helpers\StringHelper;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class TextareaMarkdown extends Component
{
    public string $activeTab = 'write';

    #[Rule('required|min:1|max:65535')]
    public string $body = '';

    public string $previewBody = '';

    public function mount(string $body = ''): void
    {
        $this->body = $body;
    }

    public function render(): View
    {
        return view('livewire.textarea-markdown');
    }

    public function toggle(string $mode): void
    {
        $this->previewBody = '';
        $this->activeTab = $mode;

        if ($mode === 'preview') {
            $this->preview();
        }
    }

    public function preview(): void
    {
        if ($this->body !== '') {
            $this->previewBody = StringHelper::parse($this->body);
        }
    }
}
