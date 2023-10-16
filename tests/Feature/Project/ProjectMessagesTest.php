<?php

namespace Tests\Feature\Project;

use App\Livewire\Projects\ManageMessageReactions;
use App\Livewire\Projects\ManageTaskLists;
use App\Models\Message;
use App\Models\Organization;
use App\Models\Project;
use App\Models\Reaction;
use App\Models\TaskList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectMessagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_see_a_list_of_messages(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $organization->id,
            'first_name' => 'Regis',
        ]);
        $project = Project::factory()->create([
            'name' => 'Paper',
            'organization_id' => $organization->id,
            'is_public' => true,
        ]);
        $user->projects()->attach($project);
        Message::factory()->create([
            'project_id' => $project->id,
            'title' => 'this is my best friend',
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/messages')
            ->assertStatus(200)
            ->assertSee('this is my best friend');
    }

    /** @test */
    public function message_can_be_created(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $organization->id,
            'first_name' => 'Regis',
        ]);
        $project = Project::factory()->create([
            'name' => 'Paper',
            'organization_id' => $organization->id,
            'is_public' => true,
        ]);
        $user->projects()->attach($project);

        $this->actingAs($user)
            ->post('/projects/' . $project->id . '/messages', [
                'title' => 'Microsoft',
                'body' => 'this is my best friend',
            ])
            ->assertStatus(302);

        $this->assertDatabaseHas('messages', [
            'project_id' => $project->id,
            'title' => 'Microsoft',
            'body' => 'this is my best friend',
        ]);
    }

    /** @test */
    public function message_can_be_edited(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $organization->id,
            'first_name' => 'Regis',
        ]);
        $project = Project::factory()->create([
            'name' => 'Paper',
            'organization_id' => $organization->id,
            'is_public' => true,
        ]);
        $user->projects()->attach($project);
        $message = Message::factory()->create([
            'project_id' => $project->id,
        ]);

        $this->actingAs($user)
            ->post('/projects/' . $project->id . '/messages/' . $message->id.'/update', [
                'title' => 'test',
                'body' => 'test',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('project.message.show', [
                'project' => $project,
                'message' => $message,
            ]);

        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'project_id' => $project->id,
            'title' => 'test',
            'body' => 'test',
        ]);
    }

    /** @test */
    public function message_can_be_deleted(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $organization->id,
            'first_name' => 'Regis',
        ]);
        $project = Project::factory()->create([
            'name' => 'Paper',
            'organization_id' => $organization->id,
            'is_public' => true,
        ]);
        $user->projects()->attach($project);
        $message = Message::factory()->create([
            'project_id' => $project->id,
        ]);

        $this->actingAs($user)
            ->delete('/projects/' . $project->id . '/messages/' . $message->id)
            ->assertStatus(302)
            ->assertRedirectToRoute('project.message.index', [
                'project' => $project,
            ]);
    }

    /** @test */
    public function reaction_component_exists_on_the_page(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $message = Message::factory()->create([
            'project_id' => $project->id,
        ]);
        TaskList::factory()->create([
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/messages/' . $message->id)
            ->assertSeeLivewire(ManageMessageReactions::class);
    }

    /** @test */
    public function we_can_add_a_reaction(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();

        Livewire::actingAs($user)
            ->test(ManageMessageReactions::class, [
                'messageId' => $message->id,
                'reactions' => collect(),
            ])
            ->call('save', '👍')
            ->assertSee('👍');

        $this->assertDatabaseHas('reactions', [
            'reactionable_id' => $message->id,
            'reactionable_type' => Message::class,
            'emoji' => '👍',
        ]);
    }

    /** @test */
    public function we_can_remove_a_reaction(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();
        $reaction = Reaction::factory()->create([
            'reactionable_id' => $message->id,
            'reactionable_type' => Message::class,
            'user_id' => $user->id,
            'emoji' => '👍',
        ]);

        Livewire::actingAs($user)
            ->test(ManageMessageReactions::class, [
                'messageId' => $message->id,
                'reactions' => $message->reactions()->get()->map(fn (Reaction $reaction) => [
                    'id' => $reaction->id,
                    'emoji' => $reaction->emoji,
                    'author' => [
                        'id' => $reaction->user->id,
                        'name' => $reaction->user->name,
                        'avatar' => $reaction->user->avatar,
                    ],
                ]),
            ])
            ->call('destroy', $reaction->id);

        $this->assertDatabaseMissing('reactions', [
            'id' => $reaction->id,
        ]);
    }

    /** @test */
    public function tasks_component_exists_on_the_page(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $message = Message::factory()->create([
            'project_id' => $project->id,
        ]);
        TaskList::factory()->create([
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/messages/' . $message->id)
            ->assertSeeLivewire(ManageTaskLists::class);
    }

    /** @test */
    public function we_can_toggle_the_task_list(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();
        $taskList = TaskList::factory()->create([
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
        ]);

        Livewire::actingAs($user)
            ->test(ManageTaskLists::class, [
                'taskList' => [
                    'id' => $taskList->id,
                    'name' => $taskList->name,
                    'collapsed' => false,
                    'tasks' => collect(),
                    'parent' => [
                        'id' => $message->id,
                        'is_project' => false,
                    ],
                ],
                'context' => 'message',
            ])
            ->call('toggle');

        $this->assertDatabaseHas('task_lists', [
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
            'collapsed' => true,
        ]);
    }

    /** @test */
    public function we_can_add_a_task(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();
        $taskList = TaskList::factory()->create([
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
        ]);

        Livewire::actingAs($user)
            ->test(ManageTaskLists::class, [
                'taskList' => [
                    'id' => $taskList->id,
                    'name' => $taskList->name,
                    'collapsed' => false,
                    'tasks' => collect(),
                    'parent' => [
                        'id' => $message->id,
                        'is_project' => false,
                    ],
                ],
                'context' => 'message',
            ])
            ->set('title', 'test')
            ->call('save')
            ->assertSee('test');

        $this->assertDatabaseHas('tasks', [
            'task_list_id' => $taskList->id,
            'title' => 'test',
        ]);
    }

    /** @test */
    public function we_can_update_a_task(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();
        $taskList = TaskList::factory()->create([
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
        ]);
        $task = $taskList->tasks()->create([
            'title' => 'test',
        ]);

        Livewire::actingAs($user)
            ->test(ManageTaskLists::class, [
                'taskList' => [
                    'id' => $taskList->id,
                    'name' => $taskList->name,
                    'collapsed' => false,
                    'tasks' => collect()->push([
                        'id' => $task->id,
                        'title' => $task->title,
                        'is_completed' => $task->is_completed,
                        'assignees' => [],
                        'url' => '',
                    ]),
                    'parent' => [
                        'id' => $message->id,
                        'is_project' => false,
                    ],
                ],
                'context' => 'message',
            ])
            ->set('title', 'real text')
            ->call('update', $task->id)
            ->assertSee('real text');

        $this->assertDatabaseHas('tasks', [
            'task_list_id' => $taskList->id,
            'title' => 'real text',
        ]);
    }

    /** @test */
    public function we_can_toggle_a_task(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();
        $taskList = TaskList::factory()->create([
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
        ]);
        $task = $taskList->tasks()->create([
            'title' => 'test',
            'is_completed' => false,
        ]);

        Livewire::actingAs($user)
            ->test(ManageTaskLists::class, [
                'taskList' => [
                    'id' => $taskList->id,
                    'name' => $taskList->name,
                    'collapsed' => false,
                    'tasks' => collect()->push([
                        'id' => $task->id,
                        'title' => $task->title,
                        'is_completed' => $task->is_completed,
                        'assignees' => [],
                        'url' => 'url',
                    ]),
                    'parent' => [
                        'id' => $message->id,
                        'is_project' => false,
                    ],
                ],
                'context' => 'message',
            ])
            ->set('title', 'real text')
            ->call('checkTask', $task->id);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => true,
        ]);
    }
}
