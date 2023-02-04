<?php

namespace Tests\Unit;

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
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

        $data = User::factory()->make()->attributesToArray();
        $response = $this->actingAs($user)
            ->post(route('users.store'), $data);

        unset($data['password'], $data['email_verified_at']);

        $response->assertJson($data);


        $this->assertDatabaseHas('users', $data);

        $id = $response->json()['id'];

        $data['name'] = 'Modified';

        $this->actingAs($user)
            ->put(route('users.update', ['user' => $id]), $data)
            ->assertJson([
                'id' => $id,
                ...$data
            ]);

        $this->assertDatabaseHas('users', $data);

        $this->actingAs($user)
            ->get(route('users.index'))
            ->assertJsonStructure(['data', 'links', 'meta']);

        $this->actingAs($user)
            ->get(route('users.show', ['user' => $id]))->assertOk();

        $this->actingAs($user)
            ->get(route('users.show', ['user' => $id]))->assertJson($data);

        $this->actingAs($user)
            ->delete(route('users.destroy', ['user' => $id]));

        $this->assertDatabaseMissing('users', $data);

    }
}
