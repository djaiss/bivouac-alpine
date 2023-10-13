<?php

namespace Tests\Unit\ViewModels\Projects;

use App\Models\Comment;
use App\Models\Message;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\Reaction;
use App\Models\TaskList;
use App\Models\User;
use App\ViewModels\Projects\ProjectMessageViewModel;
use App\ViewModels\Projects\ProjectResourceViewModel;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProjectResourceViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_index_view(): void
    {
        $project = Project::factory()->create();
        $projectResource = ProjectResource::factory()->create([
            'project_id' => $project->id,
            'label' => 'Microsoft',
            'link' => 'https://microsoft.com',
        ]);

        $array = ProjectResourceViewModel::index($project);
        $this->assertCount(2, $array);
        $this->assertArrayHasKey('project_resources', $array);
        $this->assertArrayHasKey('url', $array);
        $this->assertEquals(
            [
                'resource' => [
                    'create' => env('APP_URL') . '/projects/' . $project->id . '/resources/create',
                ]
            ],
            $array['url']
        );
    }

    /** @test */
    public function it_gets_the_dto(): void
    {
        $project = Project::factory()->create();
        $projectResource = ProjectResource::factory()->create([
            'project_id' => $project->id,
            'label' => 'Microsoft',
            'link' => 'https://microsoft.com',
        ]);

        $array = ProjectResourceViewModel::dto($projectResource);

        $this->assertCount(4, $array);
        $this->assertEquals(
            [
                'id' => $projectResource->id,
                'label' => 'Microsoft',
                'link' => 'https://microsoft.com',
                'url' => [
                    'index' => env('APP_URL') . '/projects/' . $project->id . '/resources',
                    'edit' => env('APP_URL') . '/projects/' . $project->id . '/resources/' . $projectResource->id . '/edit',
                    'update' => env('APP_URL') . '/projects/' . $project->id . '/resources/' . $projectResource->id,
                    'destroy' => env('APP_URL') . '/projects/' . $project->id . '/resources/' . $projectResource->id,
                ],
            ],
            $array
        );
    }

    /** @test */
    public function it_gets_the_create_view(): void
    {
        $project = Project::factory()->create();

        $array = ProjectResourceViewModel::create($project);

        $this->assertCount(1, $array);
        $this->assertArrayHasKey('url', $array);
        $this->assertEquals(
            [
                'resource' => [
                    'index' => env('APP_URL') . '/projects/' . $project->id . '/resources',
                    'store' => env('APP_URL') . '/projects/' . $project->id . '/resources',
                ],
            ],
            $array['url']
        );
    }
}
