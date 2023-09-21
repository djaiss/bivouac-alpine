<?php

namespace Tests\Unit\Services;

use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\Services\DestroyMessage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DestroyMessageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_destroys_a_message(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $user->projects()->attach($project->id);
        $message = Message::factory()->create([
            'project_id' => $project->id,
        ]);

        (new DestroyMessage)->execute($message);

        $this->assertDatabaseMissing('messages', [
            'id' => $message->id,
        ]);
    }
}
