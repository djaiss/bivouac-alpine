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
    public function component_exists_on_the_page()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id)
            ->assertSeeLivewire(ManageKeyResources::class);
    }

    /** @test */
    public function we_can_add_a_resource()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);

        Livewire::actingAs($user)
            ->test(ManageKeyResources::class, ['data' => [
                'project_id' => $project->id,
                'project_resources' => collect(),
            ]])
            ->set('label', 'Wrinkly fingers? Try this one weird trick')
            ->set('link', 'https://slack.com')
            ->call('save');

        $this->assertDatabaseHas('project_resources', [
            'project_id' => $project->id,
            'label' => 'Wrinkly fingers? Try this one weird trick',
            'link' => 'https://slack.com',
        ]);
    }

    /** @test */
    public function we_can_edit_a_resource()
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

        Livewire::actingAs($user)
            ->test(ManageKeyResources::class, ['data' => [
                'project_id' => $project->id,
                'project_resources' => collect(),
            ]])
            ->set('label', 'Random text')
            ->set('link', 'https://slack.com/test')
            ->call('update', $projectResource->id);

        $this->assertDatabaseHas('project_resources', [
            'project_id' => $project->id,
            'label' => 'Random text',
            'link' => 'https://slack.com/test',
        ]);
    }

    /** @test */
    public function we_can_delete_a_resource()
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

        Livewire::actingAs($user)
            ->test(ManageKeyResources::class, ['data' => [
                'project_id' => $project->id,
                'project_resources' => collect(),
            ]])
            ->call('destroy', $projectResource->id);

        $this->assertDatabaseMissing('project_resources', [
            'id' => $projectResource->id,
        ]);
    }
}
