<?php

namespace Tests\Unit\Services;

use App\Exceptions\NotEnoughPermissionException;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\User;
use App\Services\DestroyProjectResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DestroyProjectResourceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_destroys_a_project_resource(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $project = Project::factory()->create();
        $projectResource = ProjectResource::factory()->create([
            'project_id' => $project->id,
        ]);

        (new DestroyProjectResource)->execute($projectResource);

        $this->assertDatabaseMissing('project_resources', [
            'id' => $projectResource->id,
        ]);

        $this->assertDatabaseHas('projects', [
            'updated_at' => '2018-01-01 00:00:00',
        ]);
    }
}
