<?php

namespace Tests\Unit\Services;

use App\Models\TaskList;
use App\Services\DestroyTaskList;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DestroyTaskListTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_destroys_a_task_list(): void
    {
        $taskList = TaskList::factory()->create();

        (new DestroyTaskList)->execute(
            taskList: $taskList,
        );

        $this->assertDatabaseMissing('task_lists', [
            'id' => $taskList->id,
        ]);
    }
}
