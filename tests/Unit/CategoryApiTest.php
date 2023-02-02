<?php

namespace Tests\Unit;

use App\Models\Category;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryApiTest extends TestCase
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

        $data = Category::factory()->make()->attributesToArray();
        $response = $this->actingAs($vendor)
            ->post(route('categories.store'), $data);
        unset($data['sent_date']);

        $response->assertJson(['data' => $data]);

        $this->assertDatabaseHas('categories', $data);

        $id = $response->json()['data']['id'];

        $data['title'] = 'Modified';

        $this->actingAs($vendor)
            ->put(route('categories.update', ['category' => $id]), $data)
            ->assertJson(['data' => [
                'id' => $id,
                ...$data
            ]]);

        $this->assertDatabaseHas('categories', $data);

        $this->actingAs($vendor)
            ->get(route('categories.index'))
            ->assertJsonStructure(['data', 'links', 'meta']);

        $this->actingAs($vendor)
            ->get(route('categories.show', ['category' => $id]))->assertOk();

        $this->actingAs($vendor)
            ->get(route('categories.show', ['category' => $id]))->assertJson(['data' => $data]);

        $this->actingAs($vendor)
            ->delete(route('categories.destroy', ['category' => $id]));

        $this->assertDatabaseMissing('categories', $data);

    }
}
