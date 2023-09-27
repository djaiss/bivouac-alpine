<?php

namespace App\Livewire\Projects;

use App\Helpers\StringHelper;
use App\Services\AddCommentToMessage;
use App\Services\DestroyReaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ManageMessageComments extends Component
{
    #[Reactive]
    public $value = '';

    #[Locked]
    public int $messageId = 0;

    public Collection $comments;

    public function mount(int $messageId, Collection $comments): void
    {
        $this->messageId = $messageId;
        $this->comments = $comments;
    }

    public function render(): View
    {
        return view('livewire.comment');
    }

    public function save(): void
    {
        dd($this->value);
        $comment = (new AddCommentToMessage)->execute(
            messageId: $this->messageId,
            body: $this->body,
        );

        $this->comments->push([
            'id' => $comment->id,
            'author' => [
                'id' => $comment->user->id,
                'name' => $comment->user->name,
                'avatar' => $comment->user->avatar,
            ],
            'body' => StringHelper::parse($comment->body),
            'body_raw' => $comment->body,
            'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
        ]);
    }

    public function destroy(int $commentId): void
    {
        (new DestroyReaction)->execute([
            'user_id' => auth()->user()->id,
            'comment_id' => $commentId,
        ]);

        $this->comments = $this->comments->reject(fn ($comment) => $comment['id'] === $commentId);
    }
}
