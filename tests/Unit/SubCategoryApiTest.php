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
        $user = User::first();
        $this->assertNotNull($user);
        $data = SubCategory::factory()->make()->attributesToArray();
        $response = $this->actingAs($user)
            ->post(route('subCategories.store'), $data); 

          unset($data['sent_date']);    

        $response->assertJson(['data' => $data]);
      

        $this->assertDatabaseHas('sub_categories', $data);
      
        $id = $response->json()['data']['id'];

        $this->actingAs($user)
            ->put(route('subCategories.update',['subCategory' => $id]), $data)
            ->assertJson(['data' => [
                'id' => $id,
                ...$data
            ]]);

        $this->assertDatabaseHas('sub_categories', $data);

        $this->actingAs($user)
            ->get(route('subCategories.index'))
            ->assertJsonStructure(['data', 'links', 'meta']);
       

        $this->actingAs($user)
            ->get(route('subCategories.show', ['subCategory' => $id]))->assertOk();

        $this->actingAs($user)
            ->get(route('subCategories.show', ['subCategory' => $id]))->assertJson(['data' => $data]);


        $this->actingAs($user)
            ->delete(route('subCategories.destroy', ['subCategory' => $id]));

        $this->assertDatabaseMissing('sub_categories', $data);

    }
}
