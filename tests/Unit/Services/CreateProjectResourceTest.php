<?php

namespace Tests\Unit\Services;

use App\Jobs\UpdateProjectLastUpdatedAt;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Services\CreateProjectResource;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CreateProjectResourceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_project_resource(): void
    {
        Queue::fake();

        $project = Project::factory()->create();

        $projectResource = (new CreateProjectResource)->execute(
            projectId: $project->id,
            label: 'Dunder',
            link: 'https://laravel-livewire.com/',
        );

        $this->assertInstanceOf(
            ProjectResource::class,
            $projectResource
        );

        $this->assertDatabaseHas('project_resources', [
            'id' => $projectResource->id,
            'project_id' => $project->id,
            'label' => 'Dunder',
            'link' => 'https://laravel-livewire.com/',
        ]);

        Queue::assertPushed(UpdateProjectLastUpdatedAt::class, function ($event) use ($project) {
            return $event->projectId === $project->id;
        });
    }
}
