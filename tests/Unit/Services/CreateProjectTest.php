<?php

namespace Tests\Unit\Services;

use App\Models\Project;
use App\Models\User;
use App\Services\CreateProject;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateProjectTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_project(): void
    {
        $author = User::factory()->create();
        $this->be($author);

        $project = (new CreateProject)->execute(
            name: 'Dunder',
            description: 'this is a description',
            isPublic: true,
        );

        $this->assertInstanceOf(
            Project::class,
            $project
        );

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'organization_id' => $author->organization_id,
            'name' => 'Dunder',
            'short_description' => 'this is a description',
            'is_public' => true,
        ]);

        $this->assertDatabaseHas('project_user', [
            'project_id' => $project->id,
            'user_id' => $author->id,
        ]);
    }
}
