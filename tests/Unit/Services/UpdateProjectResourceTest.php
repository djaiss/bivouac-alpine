<?php

namespace Tests\Unit\Services;

use App\Jobs\UpdateProjectLastUpdatedAt;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\User;
use App\Services\DestroyProjectResource;
use App\Services\UpdateProjectResource;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UpdateProjectResourceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_a_project_resource(): void
    {
        Queue::fake();

        $project = Project::factory()->create();
        $projectResource = ProjectResource::factory()->create([
            'project_id' => $project->id,
        ]);

        (new UpdateProjectResource)->execute(
            projectResource: $projectResource,
            link: 'https://example.com',
            label: 'Example',
        );

        $this->assertDatabaseHas('project_resources', [
            'id' => $projectResource->id,
            'link' => 'https://example.com',
            'label' => 'Example',
        ]);

        Queue::assertPushed(UpdateProjectLastUpdatedAt::class, function ($event) use ($project) {
            return $event->projectId === $project->id;
        });
    }
}
