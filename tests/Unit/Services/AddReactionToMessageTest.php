<?php

namespace Tests\Unit\Services;

use App\Models\Message;
use App\Models\Reaction;
use App\Models\User;
use App\Services\AddReactionToMessage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AddReactionToMessageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_reaction(): void
    {
        $user = User::factory()->create();
        $this->be($user);
        $message = Message::factory()->create();

        $reaction = (new AddReactionToMessage)->execute(
            emoji: '🥳',
            messageId: $message->id,
        );

        $this->assertInstanceOf(
            Reaction::class,
            $reaction
        );

        $this->assertDatabaseHas('reactions', [
            'id' => $reaction->id,
            'organization_id' => $user->organization_id,
            'emoji' => '🥳',
            'reactionable_id' => $message->id,
            'reactionable_type' => Message::class,
        ]);
    }
}
