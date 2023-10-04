<?php

namespace Tests\Unit\ViewModels\Projects;

use App\Models\Message;
use App\Models\Task;
use App\Models\TaskList;
use App\ViewModels\Projects\ProjectTaskListViewModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProjectTaskListViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_for_the_index_view(): void
    {
        $message = Message::factory()->create();
        $taskList = TaskList::factory()->create([
            'name' => 'Title',
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
        ]);
        Task::factory()->create([
            'task_list_id' => $taskList->id,
            'title' => 'Task',
            'is_completed' => true,
        ]);

        $array = ProjectTaskListViewModel::index($message->project);

        $this->assertCount(1, $array);
        $this->assertArrayHasKey('task_lists', $array);
    }

    /** @test */
    public function it_gets_the_dto(): void
    {
        $message = Message::factory()->create();
        $taskList = TaskList::factory()->create([
            'name' => 'Title',
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
        ]);
        Task::factory()->create([
            'task_list_id' => $taskList->id,
            'title' => 'Task',
            'is_completed' => true,
        ]);
        $array = ProjectTaskListViewModel::dto($taskList);

        $this->assertCount(6, $array);
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('completion_rate', $array);
        $this->assertArrayHasKey('tasks', $array);
        $this->assertArrayHasKey('collapsed', $array);
        $this->assertArrayHasKey('parent', $array);

        $this->assertEquals(
            $taskList->id,
            $array['id']
        );
        $this->assertEquals(
            'Title',
            $array['name']
        );
        $this->assertEquals(
            100,
            $array['completion_rate']
        );
        $this->assertFalse(
            $array['collapsed']
        );
        $this->assertEquals(
            [
                'id' => $message->id,
                'title' => $message->title,
                'is_project' => false,
                'url' => env('APP_URL') . '/projects/' . $message->project_id . '/messages/' . $message->id,
            ],
            $array['parent']
        );
    }

    /** @test */
    public function it_gets_the_data_for_the_edit_view(): void
    {
        $taskList = TaskList::factory()->create([
            'name' => 'Title',
        ]);

        $array = ProjectTaskListViewModel::edit($taskList);

        $this->assertCount(2, $array);
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('title', $array);
        $this->assertEquals(
            [
                'id' => $taskList->id,
                'title' => 'Title',
            ],
            $array
        );
    }

    /** @test */
    public function it_gets_the_data_for_the_delete_view(): void
    {
        $taskList = TaskList::factory()->create([
            'name' => 'Title',
        ]);

        $array = ProjectTaskListViewModel::delete($taskList);

        $this->assertCount(1, $array);
        $this->assertArrayHasKey('id', $array);
        $this->assertEquals(
            [
                'id' => $taskList->id,
            ],
            $array
        );
    }
}
