<?php

namespace Tests\Unit\Services;

use App\Jobs\UpdateProjectLastUpdatedAt;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Services\DestroyProjectResource;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class DestroyProjectResourceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_deletes_a_project_resource(): void
    {
        Queue::fake();

        $project = Project::factory()->create();
        $projectResource = ProjectResource::factory()->create([
            'project_id' => $project->id,
        ]);

        (new DestroyProjectResource)->execute($projectResource);

        $this->assertDatabaseMissing('project_resources', [
            'id' => $projectResource->id,
        ]);

        Queue::assertPushed(UpdateProjectLastUpdatedAt::class, function ($event) use ($project) {
            return $event->projectId === $project->id;
        });
    }
}
