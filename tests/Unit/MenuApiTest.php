<?php

namespace Tests\Unit;

use App\Models\Menu;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuApiTest extends TestCase
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

        $admin = User::admin()->first();
        $this->assertNotNull($admin);

        $data = Menu::factory()->make()->attributesToArray();
        $response = $this->actingAs($admin)
            ->post(route('menus.store'), $data);

        $response->assertJson(['data' => $data]);

        $this->assertDatabaseHas('menus', $data);

        $id = $response->json()['data']['id'];

        $this->actingAs($vendor)
            ->put(route('menus.update', ['menu' => $id]), $data)
            ->assertJson(['data' => [
                'id' => $id,
                ...$data
            ]]);

        $this->assertDatabaseHas('menus', $data);

        $this->actingAs($admin)
            ->get(route('menus.index'))
            ->assertJsonStructure(['data', 'links', 'meta']);

        $this->actingAs($vendor)
            ->get(route('menus.show', ['menu' => $id]))->assertOk();

        $this->actingAs($vendor)
            ->get(route('menus.show', ['menu' => $id]))->assertJson(['data' => $data]);

        $this->actingAs($admin)
            ->delete(route('menus.destroy', ['menu' => $id]));

        $data['id'] = $id;

        $this->assertDatabaseMissing('menus', $data);

    }
}
