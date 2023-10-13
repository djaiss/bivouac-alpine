<?php

namespace Tests\Feature\Project;

use App\Livewire\Projects\ManageKeyResources;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectResourcesTest extends TestCase
{
    /** @test */
    public function we_can_list_resources(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        ProjectResource::factory()->create([
            'project_id' => $project->id,
            'label' => 'Wrinkly fingers? Try this one weird trick',
            'link' => 'https://slack.com',
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id.'/resources')
            ->assertStatus(200)
            ->assertSee('https://slack.com')
            ->assertSee('Wrinkly fingers? Try this one weird trick');
    }

    /** @test */
    public function we_can_see_the_screen_to_add_a_resource(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/resources/create')
            ->assertStatus(200)
            ->assertSee('URL/link')
            ->assertSee('Label');
    }

    /** @test */
    public function we_can_add_a_resource(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);

        $this->actingAs($user)
            ->post('/projects/' . $project->id . '/resources', [
                'label' => 'This is a fake name',
                'link' => 'https://slack.com',
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('project_resources', [
            'project_id' => $project->id,
            'label' => 'This is a fake name',
            'link' => 'https://slack.com',
        ]);
    }

    /** @test */
    public function we_can_see_the_screen_to_edit_a_resource(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $projectResource = ProjectResource::factory()->create([
            'project_id' => $project->id,
            'label' => 'Wrinkly fingers? Try this one weird trick',
            'link' => 'https://slack.com',
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/resources/'.$projectResource->id.'/edit')
            ->assertStatus(200)
            ->assertSee('Wrinkly fingers? Try this one weird trick')
            ->assertSee('https://slack.com')
            ->assertSee('URL/link')
            ->assertSee('Label');
    }

    /** @test */
    public function we_can_edit_a_resource(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $projectResource = ProjectResource::factory()->create([
            'project_id' => $project->id,
            'label' => 'Wrinkly fingers? Try this one weird trick',
            'link' => 'https://slack.com',
        ]);

        $this->actingAs($user)
            ->put('/projects/' . $project->id . '/resources/' . $projectResource->id, [
                'label' => 'This is a fake name',
                'link' => 'https://microsoft.com',
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('project_resources', [
            'project_id' => $project->id,
            'label' => 'This is a fake name',
            'link' => 'https://microsoft.com',
        ]);
    }

    /** @test */
    public function we_can_delete_a_resource(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $projectResource = ProjectResource::factory()->create([
            'project_id' => $project->id,
            'label' => 'Wrinkly fingers? Try this one weird trick',
            'link' => 'https://slack.com',
        ]);

        $this->actingAs($user)
            ->delete('/projects/' . $project->id . '/resources/' . $projectResource->id)
            ->assertStatus(200);

        $this->assertDatabaseMissing('project_resources', [
            'id' => $projectResource->id,
        ]);
    }
}
