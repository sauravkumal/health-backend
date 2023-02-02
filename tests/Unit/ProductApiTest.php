<?php

namespace Tests\Unit;

use App\Models\Product;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
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

        $data = Product::factory()->make()->attributesToArray();
        $response = $this->actingAs($vendor)
            ->post(route('products.store'), $data);
        unset($data['sent_date']);

        $response->assertJson(['data' => $data]);

        unset($data['thumb_image_url']);
        $this->assertDatabaseHas('products', $data);


        $id = $response->json()['data']['id'];

        $data['title'] = 'Modified';

        $this->actingAs($vendor)
            ->put(route('products.update', ['product' => $id]), $data)
            ->assertJson(['data' => [
                'id' => $id,
                ...$data
            ]]);

        $this->assertDatabaseHas('products', $data);

        $this->actingAs($vendor)
            ->get(route('products.index'))
            ->assertJsonStructure(['data', 'links', 'meta']);

        $this->actingAs($vendor)
            ->get(route('products.show', ['product' => $id]))->assertOk();

        $this->actingAs($vendor)
            ->get(route('products.show', ['product' => $id]))->assertJson(['data' => $data]);


        $this->actingAs($vendor)
            ->delete(route('products.destroy', ['product' => $id]));

        $this->assertDatabaseMissing('products', $data);

    }
}
