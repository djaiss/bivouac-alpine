<?php

namespace Tests\Unit\Services;

use App\Models\Project;
use App\Services\DestroyProject;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DestroyProjectTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_destroys_a_project(): void
    {
        $project = Project::factory()->create();

        (new DestroyProject)->execute($project);

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }
}
