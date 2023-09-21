<?php

namespace Tests\Unit\ViewModels\Projects;

use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\ViewModels\Projects\ProjectMessageViewModel;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProjectMessageViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_index_view(): void
    {
        $user = User::factory()->create();
        $this->be($user);
        $project = Project::factory()->create(['name' => 'Dunder']);
        $newAndReadMessage = Message::factory()->create([
            'project_id' => $project->id,
            'title' => 'New and read',
            'created_at' => Carbon::create(2018, 1, 1),
        ]);
        $oldAndUnreadMessage = Message::factory()->create([
            'project_id' => $project->id,
            'title' => 'Old and unread',
            'created_at' => Carbon::create(2011, 1, 1),
        ]);
        DB::table('message_read_status')->insert([
            'message_id' => $newAndReadMessage->id,
            'user_id' => $user->id,
        ]);

        $array = ProjectMessageViewModel::index($project);

        $this->assertCount(2, $array);
        $this->assertArrayHasKey('project_id', $array);
        $this->assertArrayHasKey('messages', $array);
        $this->assertEquals(
            [
                0 => [
                    'id' => $newAndReadMessage->id,
                    'title' => 'New and read',
                    'read' => true,
                    'author' => [
                        'name' => $newAndReadMessage->user->name,
                        'avatar' => $newAndReadMessage->user->avatar,
                        'id' => $newAndReadMessage->user_id,
                    ],
                ],
                1 => [
                    'id' => $oldAndUnreadMessage->id,
                    'title' => 'Old and unread',
                    'read' => false,
                    'author' => [
                        'name' => $oldAndUnreadMessage->user->name,
                        'avatar' => $oldAndUnreadMessage->user->avatar,
                        'id' => $oldAndUnreadMessage->user_id,
                    ],
                ],
            ],
            $array['messages']->toArray()
        );
    }

    /** @test */
    public function it_gets_the_create_view(): void
    {
        $project = Project::factory()->create();

        $array = ProjectMessageViewModel::create($project);

        $this->assertCount(1, $array);
        $this->assertArrayHasKey('project_id', $array);
        $this->assertEquals(['project_id' => $project->id], $array);
    }

    /** @test */
    public function it_gets_the_show_view(): void
    {
        $message = Message::factory()->create([
            'title' => 'Microsoft',
            'body' => 'this is my best friend',
            'created_at' => Carbon::create(2018, 1, 1),
        ]);

        $array = ProjectMessageViewModel::show($message);

        $this->assertCount(5, $array);
        $this->assertEquals(
            $message->id,
            $array['id']
        );
        $this->assertEquals(
            'Microsoft',
            $array['title']
        );
        $this->assertEquals(
            '<p>this is my best friend</p>',
            $array['body']
        );
        $this->assertEquals(
            '01/01/2018 00:00',
            $array['created_at']
        );
        $this->assertEquals(
            [
                'id' => $message->user_id,
                'name' => $message->user->name,
                'avatar' => $message->user->avatar,
            ],
            $array['author']
        );
    }

    /** @test */
    public function it_gets_the_delete_view(): void
    {
        $message = Message::factory()->create([
            'title' => 'Microsoft',
        ]);

        $array = ProjectMessageViewModel::delete($message);

        $this->assertCount(2, $array);
        $this->assertEquals(
            [
                'id' => $message->id,
                'title' => 'Microsoft',
            ],
            $array
        );
    }
}
