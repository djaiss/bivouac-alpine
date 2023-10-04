<?php

namespace Tests\Unit\Services;

use App\Models\TaskList;
use App\Models\User;
use App\Services\UpdateTaskList;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateTaskListTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_a_task_list(): void
    {
        $user = User::factory()->create();
        $taskList = TaskList::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $taskList = (new UpdateTaskList)->execute(
            taskList: $taskList,
            name: 'this is a description',
        );

        $this->assertInstanceOf(
            TaskList::class,
            $taskList
        );

        $this->assertDatabaseHas('task_lists', [
            'id' => $taskList->id,
            'organization_id' => $user->organization_id,
            'name' => 'this is a description',
        ]);
    }
}
