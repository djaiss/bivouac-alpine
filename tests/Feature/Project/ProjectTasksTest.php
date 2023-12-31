<?php

namespace Tests\Feature\Project;

use App\Livewire\Projects\ManageTask;
use App\Models\Message;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\User;
use App\ViewModels\Projects\ProjectTaskViewModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_list_of_task_lists(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $message = Message::factory()->create([
            'project_id' => $project->id,
            'title' => 'Message title',
        ]);
        $taskList = TaskList::factory()->create([
            'project_id' => $project->id,
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
        ]);
        Task::factory()->create([
            'task_list_id' => $taskList->id,
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/tasklists')
            ->assertSee('Message title');
    }

    /** @test */
    public function it_creates_a_task_list(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);

        $this->actingAs($user)
            ->post('/projects/' . $project->id . '/tasklists', [
                'title' => 'This is a fake name',
            ])
            ->assertStatus(302);

        $this->assertDatabaseHas('task_lists', [
            'name' => 'This is a fake name',
            'project_id' => $project->id,
            'tasklistable_id' => $project->id,
            'tasklistable_type' => Project::class,
        ]);
    }

    /** @test */
    public function it_edits_a_task_list(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $taskList = TaskList::factory()->create([
            'project_id' => $project->id,
            'tasklistable_id' => $project->id,
            'tasklistable_type' => Project::class,
        ]);

        $this->actingAs($user)
            ->put('/projects/' . $project->id . '/tasklists/' . $taskList->id, [
                'title' => 'This is a fake name',
            ])
            ->assertStatus(302);

        $this->assertDatabaseHas('task_lists', [
            'name' => 'This is a fake name',
            'project_id' => $project->id,
            'tasklistable_id' => $project->id,
            'tasklistable_type' => Project::class,
        ]);
    }

    /** @test */
    public function it_deletes_a_task_list(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $taskList = TaskList::factory()->create([
            'project_id' => $project->id,
            'tasklistable_id' => $project->id,
            'tasklistable_type' => Project::class,
        ]);

        $this->actingAs($user)
            ->delete('/projects/' . $project->id . '/tasklists/' . $taskList->id)
            ->assertStatus(302);

        $this->assertDatabaseMissing('task_lists', [
            'id' => $taskList->id,
        ]);
    }

    /** @test */
    public function the_component_exists_on_the_message_page(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $taskList = TaskList::factory()->create([
            'project_id' => $project->id,
        ]);
        $task = Task::factory()->create([
            'task_list_id' => $taskList->id,
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/tasklists/' . $taskList->id . '/tasks/' . $task->id)
            ->assertSeeLivewire(ManageTask::class);
    }

    /** @test */
    public function the_task_title_can_be_edited(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $taskList = TaskList::factory()->create([
            'project_id' => $project->id,
        ]);
        $task = Task::factory()->create([
            'task_list_id' => $taskList->id,
        ]);

        Livewire::actingAs($user)
            ->test(ManageTask::class, ['task' => ProjectTaskViewModel::show($task)])
            ->set('title', 'this is a title')
            ->call('save');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'this is a title',
        ]);
    }

    /** @test */
    public function the_task_description_can_be_edited(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $taskList = TaskList::factory()->create([
            'project_id' => $project->id,
        ]);
        $task = Task::factory()->create([
            'task_list_id' => $taskList->id,
        ]);

        Livewire::actingAs($user)
            ->test(ManageTask::class, ['task' => ProjectTaskViewModel::show($task)])
            ->set('description', 'this is a description')
            ->call('saveDescription');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'description' => 'this is a description',
        ]);
    }
}
