<?php

namespace Tests\Unit\Services;

use App\Models\Project;
use App\Services\UpdateProject;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateProjectTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_a_project(): void
    {
        $project = Project::factory()->create([
            'is_public' => false,
        ]);

        $project = (new UpdateProject)->execute(
            project: $project,
            name: 'Dunder',
            description: 'this is a description',
            shortDescription: 'this is a short description',
            isPublic: true,
        );

        $this->assertInstanceOf(
            Project::class,
            $project
        );

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Dunder',
            'description' => 'this is a description',
            'short_description' => 'this is a short description',
            'is_public' => true,
        ]);
    }
}
