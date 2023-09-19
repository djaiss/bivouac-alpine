<?php

namespace Tests\Unit\Services;

use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\Services\MarkMessageAsRead;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MarkMessageAsReadTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_the_read_status_of_a_message(): void
    {
        $user = User::factory()->create();
        $this->be($user);
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $user->projects()->attach($project->id);
        $message = Message::factory()->create([
            'project_id' => $project->id,
        ]);

        (new MarkMessageAsRead)->execute($message->id);

        $this->assertDatabaseHas('message_read_status', [
            'user_id' => $user->id,
            'message_id' => $message->id,
        ]);
    }
}
