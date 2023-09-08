<?php

namespace Tests\Unit\ViewModels\Settings;

use App\Models\Office;
use App\Models\Organization;
use App\ViewModels\Settings\SettingsOfficeViewModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsOfficeViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_index_view(): void
    {
        $organization = Organization::factory()->create();
        $array = SettingsOfficeViewModel::index($organization);

        $this->assertCount(1, $array);
        $this->assertArrayHasKey('offices', $array);
    }

    /** @test */
    public function it_gets_the_dto_for_office(): void
    {
        $office = Office::factory()->create([
            'name' => 'Dunder',
            'is_main_office' => true,
        ]);
        $array = SettingsOfficeViewModel::dto($office);

        $this->assertCount(3, $array);
        $this->assertEquals(
            [
                'id' => $office->id,
                'name' => 'Dunder',
                'is_main_office' => true,
            ],
            $array
        );
    }
}
