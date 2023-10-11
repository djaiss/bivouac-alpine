<?php

namespace Tests\Unit\Services;

use App\Models\Reaction;
use App\Models\Task;
use App\Models\User;
use App\Services\AddReactionToTask;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AddReactionToTaskTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_reaction(): void
    {
        $user = User::factory()->create();
        $this->be($user);
        $task = Task::factory()->create();

        $reaction = (new AddReactionToTask)->execute(
            emoji: '🥳',
            taskId: $task->id,
        );

        $this->assertInstanceOf(
            Reaction::class,
            $reaction
        );

        $this->assertDatabaseHas('reactions', [
            'id' => $reaction->id,
            'organization_id' => $user->organization_id,
            'emoji' => '🥳',
            'reactionable_id' => $task->id,
            'reactionable_type' => Task::class,
        ]);
    }
}
