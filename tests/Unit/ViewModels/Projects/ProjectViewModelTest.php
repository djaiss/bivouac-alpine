<?php

namespace Tests\Unit\ViewModels\Projects;

use App\Models\Organization;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\User;
use App\ViewModels\Projects\ProjectViewModel;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProjectViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_index_view(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        config(['app.store.activated' => true]);
        $organization = Organization::factory()->create([
            'licence_key' => null,
        ]);
        $project = Project::factory()->create([
            'organization_id' => $organization->id,
            'name' => 'Dunder',
            'short_description' => 'this is a description',
            'is_public' => false,
            'updated_at' => Carbon::now()->subYear(),
        ]);
        $user = User::factory()->create([
            'organization_id' => $organization->id,
        ]);
        $project->users()->attach($user->id);
        $array = ProjectViewModel::index($user);

        $this->assertCount(2, $array);
        $this->assertArrayHasKey('needs_upgrade', $array);
        $this->assertArrayHasKey('projects', $array);

        $this->assertTrue($array['needs_upgrade']);

        $this->assertEquals(
            $project->id,
            $array['projects'][0]['id']
        );
        $this->assertEquals(
            'Dunder',
            $array['projects'][0]['name']
        );
        $this->assertEquals(
            'this is a description',
            $array['projects'][0]['short_description']
        );
        $this->assertEquals(
            '1 year ago',
            $array['projects'][0]['updated_at']
        );
        $this->assertFalse($array['projects'][0]['is_public']);
        $this->assertEquals(
            [
                0 => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                ],
            ],
            $array['projects'][0]['members']->toArray()
        );
        $this->assertEquals(
            0,
            $array['projects'][0]['other_members_counter']
        );
    }

    /** @test */
    public function it_gets_the_data_for_the_header(): void
    {
        $project = Project::factory()->create([
            'name' => 'Dunder',
            'short_description' => 'Dunder Mifflin',
            'is_public' => true,
        ]);
        $array = ProjectViewModel::header($project);

        $this->assertCount(4, $array);
        $this->assertEquals(
            [
                'id' => $project->id,
                'name' => 'Dunder',
                'short_description' => 'Dunder Mifflin',
                'is_public' => true,
            ],
            $array
        );
    }

    /** @test */
    public function it_gets_the_data_for_the_show_page(): void
    {
        $project = Project::factory()->create([
            'name' => 'Dunder',
            'description' => 'Dunder Mifflin',
        ]);
        $projectResource = ProjectResource::factory()->create([
            'project_id' => $project->id,
            'name' => 'Dunder',
            'link' => 'https://slack.com',
        ]);
        $array = ProjectViewModel::show($project);

        $this->assertCount(2, $array);

        $this->assertEquals(
            '<p>Dunder Mifflin</p>
',
            $array['description']
        );

        $this->assertEquals(
            [
                0 => [
                    'id' => $projectResource->id,
                    'name' => 'Dunder',
                    'link' => 'https://slack.com',
                ],
            ],
            $array['project_resources']->toArray()
        );
    }

    /** @test */
    public function it_gets_the_data_for_the_edit_view(): void
    {
        $project = Project::factory()->create([
            'name' => 'Dunder',
            'short_description' => 'Great description',
            'description' => 'Dunder Mifflin',
            'is_public' => true,
        ]);
        $array = ProjectViewModel::edit($project);

        $this->assertCount(5, $array);
        $this->assertEquals(
            [
                'id' => $project->id,
                'name' => 'Dunder',
                'short_description' => 'Great description',
                'description' => 'Dunder Mifflin',
                'is_public' => true,
            ],
            $array
        );
    }
}
