<?php

namespace App\Livewire\Projects;

use App\Services\AddReactionToTask;
use App\Services\DestroyReaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ManageTaskReactions extends Component
{
    #[Locked]
    public int $taskId = 0;

    public Collection $reactions;

    public function mount(int $taskId, Collection $reactions): void
    {
        $this->taskId = $taskId;
        $this->reactions = $reactions;
    }

    public function render(): View
    {
        return view('livewire.reaction');
    }

    public function save(string $emoji): void
    {
        $reaction = (new AddReactionToTask)->execute($emoji, $this->taskId);

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

    public function destroy(int $reactionId): void
    {
        (new DestroyReaction)->execute([
            'user_id' => auth()->user()->id,
            'reaction_id' => $reactionId,
        ]);

        $this->reactions = $this->reactions->reject(fn ($reaction) => $reaction['id'] === $reactionId);
    }
}
