<?php

namespace Tests\Unit\Services;

use App\Models\Task;
use App\Models\TaskList;
use App\Models\User;
use App\Services\CreateTask;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_task(): void
    {
        $user = User::factory()->create();
        $this->be($user);
        $taskList = TaskList::factory()->create([
            'organization_id' => $user->organization_id,
        ]);

        $task = (new CreateTask)->execute(
            taskListId: $taskList->id,
            title: 'Super name',
        );

        $this->assertInstanceOf(
            Task::class,
            $task
        );

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'task_list_id' => $taskList->id,
            'title' => 'Super name',
        ]);
    }
}
