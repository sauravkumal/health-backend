<?php

namespace Tests\Unit;

use App\Models\SubCategory;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubCategoryApiTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_if_api_crud_are_working()
    {
        $vendor = User::vendor()->first();
        $this->assertNotNull($vendor);
        $data = SubCategory::factory()->make()->attributesToArray();
        $response = $this->actingAs($vendor)
            ->post(route('subCategories.store'), $data);

        unset($data['sent_date']);

        $response->assertJson(['data' => $data]);


        $this->assertDatabaseHas('sub_categories', $data);

        $id = $response->json()['data']['id'];

        $this->actingAs($vendor)
            ->put(route('subCategories.update', ['subCategory' => $id]), $data)
            ->assertJson(['data' => [
                'id' => $id,
                ...$data
            ]]);

        $this->assertDatabaseHas('sub_categories', $data);

        $this->actingAs($vendor)
            ->get(route('subCategories.index'))
            ->assertJsonStructure(['data', 'links', 'meta']);


        $this->actingAs($vendor)
            ->get(route('subCategories.show', ['subCategory' => $id]))->assertOk();

        $this->actingAs($vendor)
            ->get(route('subCategories.show', ['subCategory' => $id]))->assertJson(['data' => $data]);


        $this->actingAs($vendor)
            ->delete(route('subCategories.destroy', ['subCategory' => $id]));

        $this->assertDatabaseMissing('sub_categories', $data);

    }
}
