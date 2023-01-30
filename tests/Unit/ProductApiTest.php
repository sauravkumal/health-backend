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
        $user = User::first();
        $this->assertNotNull($user);

        $data= Product::factory()->make()->attributesToArray();
        $response = $this->actingAs($user)
            ->post(route('products.store'), $data);
        unset($data['sent_date']);    
            
      
        $response->assertJson(['data' => $data]);
      

        $this->assertDatabaseHas('products', $data);
      



        $id = $response->json()['data']['id'];
       
        $this->actingAs($user)
            ->put(route('products.update',['product' => $id]), $data)
            ->assertJson(['data' => [
                'id' => $id,
                ...$data
            ]]);

        $this->assertDatabaseHas('products', $data);

        $this->actingAs($user)
            ->get(route('products.index'))
            ->assertJsonStructure(['data', 'links', 'meta']);

        $this->actingAs($user)
            ->get(route('products.show', ['product' => $id]))->assertOk();

        $this->actingAs($user)
            ->get(route('products.show', ['product' => $id]))->assertJson(['data' => $data]);


        $this->actingAs($user)
            ->delete(route('products.destroy', ['product' => $id]));

        $this->assertDatabaseMissing('products', $data);

    }
}
