<?php

namespace Tests\Unit\Services;

use App\Models\TaskList;
use App\Services\ToggleTaskList;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ToggleTaskListTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_toggles_a_task_list(): void
    {
        $taskList = TaskList::factory()->create([
            'collapsed' => false,
        ]);

        $taskList = (new ToggleTaskList)->execute(
            taskListId: $taskList->id,
        );

        $this->assertInstanceOf(
            TaskList::class,
            $taskList
        );

        $this->assertDatabaseHas('task_lists', [
            'id' => $taskList->id,
            'collapsed' => true,
        ]);
    }
}
