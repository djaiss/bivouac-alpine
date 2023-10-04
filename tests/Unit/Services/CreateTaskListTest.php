<?php

namespace Tests\Unit\Services;

use App\Models\TaskList;
use App\Models\User;
use App\Services\CreateTaskList;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateTaskListTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_task_list(): void
    {
        $user = User::factory()->create();
        $this->be($user);

        $taskList = (new CreateTaskList)->execute(
            name: 'Dunder',
        );

        $this->assertInstanceOf(
            TaskList::class,
            $taskList
        );

        $this->assertDatabaseHas('task_lists', [
            'id' => $taskList->id,
            'organization_id' => $user->organization_id,
            'name' => 'Dunder',
        ]);
    }
}
