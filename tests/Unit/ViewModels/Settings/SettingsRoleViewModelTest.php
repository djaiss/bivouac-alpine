<?php

namespace Tests\Unit\ViewModels\Settings;

use App\Models\Organization;
use App\Models\Role;
use App\ViewModels\Settings\SettingsRoleViewModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsRoleViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_index_view(): void
    {
        $organization = Organization::factory()->create();
        $array = SettingsRoleViewModel::index($organization);

        $this->assertCount(1, $array);
        $this->assertArrayHasKey('roles', $array);
    }

    /** @test */
    public function it_gets_the_dto_for_role(): void
    {
        $role = Role::factory()->create([
            'label' => 'Dunder',
            'position' => 2,
        ]);
        $array = SettingsRoleViewModel::dto($role);

        $this->assertCount(3, $array);
        $this->assertEquals(
            [
                'id' => $role->id,
                'label' => 'Dunder',
                'position' => 2,
            ],
            $array
        );
    }
}
