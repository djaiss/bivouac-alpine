<?php

namespace Tests\Unit\Services;

use App\Models\Task;
use App\Models\TaskList;
use App\Models\User;
use App\Services\UpdateTask;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_a_task(): void
    {
        $user = User::factory()->create();
        $taskList = TaskList::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $task = Task::factory()->create([
            'task_list_id' => $taskList->id,
        ]);
        $task = (new UpdateTask)->execute(
            taskId: $task->id,
            title: 'this is a title',
            description: 'this is a description',
            isCompleted: true,
        );

        $this->assertInstanceOf(
            Task::class,
            $task
        );

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'this is a title',
            'description' => 'this is a description',
            'is_completed' => true,
        ]);
    }
}
