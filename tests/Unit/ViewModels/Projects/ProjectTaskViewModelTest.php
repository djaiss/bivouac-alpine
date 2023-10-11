<?php

namespace Tests\Unit\ViewModels\Projects;

use App\Models\Task;
use App\ViewModels\Projects\ProjectTaskViewModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProjectTaskViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_for_the_show_view(): void
    {
        $task = Task::factory()->create([
            'title' => 'Test task',
            'description' => 'Test description',
        ]);

        $array = ProjectTaskViewModel::show($task);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('title', $array);
        $this->assertArrayHasKey('description', $array);
        $this->assertArrayHasKey('description_raw', $array);
        $this->assertArrayHasKey('is_completed', $array);
        $this->assertArrayHasKey('assignees', $array);
        $this->assertArrayHasKey('reactions', $array);

        $this->assertEquals($task->id, $array['id']);
        $this->assertEquals('Test task', $array['title']);
        $this->assertEquals('<p>Test description</p>', $array['description']);
        $this->assertEquals('Test description', $array['description_raw']);
        $this->assertFalse($array['is_completed']);
    }
}
