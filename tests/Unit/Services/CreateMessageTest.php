<?php

namespace Tests\Unit\Services;

use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\Services\CreateMessage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateMessageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_message(): void
    {
        $user = User::factory()->create();
        $this->be($user);

        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $user->projects()->attach($project->id);

        $message = (new CreateMessage)->execute(
            projectId: $project->id,
            title: 'Dunder',
            body: 'this is a description',
        );

        $this->assertInstanceOf(
            Message::class,
            $message
        );

        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'user_id' => $user->id,
            'project_id' => $project->id,
            'title' => 'Dunder',
            'body' => 'this is a description',
        ]);

        $this->assertDatabaseHas('message_read_status', [
            'user_id' => $user->id,
            'message_id' => $message->id,
        ]);

        // $this->assertDatabaseHas('task_lists', [
        //     'organization_id' => $user->organization_id,
        //     'project_id' => $project->id,
        //     'name' => null,
        //     'tasklistable_id' => $message->id,
        //     'tasklistable_type' => Message::class,
        // ]);
    }
}
