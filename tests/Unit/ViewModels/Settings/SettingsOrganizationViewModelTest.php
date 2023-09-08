<?php

namespace Tests\Unit\ViewModels\Settings;

use App\Models\Organization;
use App\ViewModels\Settings\SettingsOrganizationViewModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsOrganizationViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $organization = Organization::factory()->create([
            'name' => 'Test Organization',
        ]);
        $array = SettingsOrganizationViewModel::index($organization);

        $this->assertEquals(
            [
                'name' => 'Test Organization',
            ],
            $array
        );
    }
}
