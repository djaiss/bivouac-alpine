<?php

namespace Tests\Unit\Services;

use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\Services\UpdateMessage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateMessageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_a_message(): void
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

        $message = (new UpdateMessage)->execute(
            message: $message,
            title: 'Dunder',
            body: 'this is a description',
        );

        $this->assertInstanceOf(
            Message::class,
            $message
        );

        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'project_id' => $project->id,
            'title' => 'Dunder',
            'body' => 'this is a description',
        ]);

        $this->assertDatabaseHas('message_read_status', [
            'user_id' => $user->id,
            'message_id' => $message->id,
        ]);
    }
}
