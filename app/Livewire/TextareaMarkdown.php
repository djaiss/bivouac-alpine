<?php

namespace App\Livewire;

use App\Helpers\StringHelper;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class TextareaMarkdown extends Component
{
    #[Modelable]
    public $body = '';

    public $activeTab = 'write';

    public $previewBody = '';

    public $minHeight = 'min-h-[400px]';

    public function mount($body = ''): void
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
