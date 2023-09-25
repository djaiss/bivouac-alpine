<?php

namespace App\Livewire\Projects;

use App\Services\AddReactionToMessage;
use App\Services\DestroyReaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ManageMessageReactions extends Component
{
    #[Locked]
    public int $messageId = 0;

    public Collection $reactions;

    public function mount(int $messageId, Collection $reactions): void
    {
        $this->messageId = $messageId;
        $this->reactions = $reactions;
    }

    public function render(): View
    {
        return view('livewire.reaction');
    }

    public function save(string $emoji)
    {
        $reaction = (new AddReactionToMessage)->execute($emoji, $this->messageId);

        $this->reactions->push([
            'id' => $reaction->id,
            'emoji' => $reaction->emoji,
            'author' => [
                'id' => $reaction->user->id,
                'name' => $reaction->user->name,
                'avatar' => $reaction->user->avatar,
            ],
        ]);
    }

    public function destroy(int $reactionId)
    {
        (new DestroyReaction)->execute([
            'user_id' => auth()->user()->id,
            'reaction_id' => $reactionId,
        ]);

        $this->reactions = $this->reactions->reject(fn ($reaction) => $reaction['id'] === $reactionId);
    }
}
