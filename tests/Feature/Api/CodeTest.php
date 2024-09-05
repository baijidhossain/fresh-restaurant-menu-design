<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Code;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CodeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_codes_list(): void
    {
        $codes = Code::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.codes.index'));

        $response->assertOk()->assertSee($codes[0]->code);
    }

    /**
     * @test
     */
    public function it_stores_the_code(): void
    {
        $data = Code::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.codes.store'), $data);

        $this->assertDatabaseHas('codes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_code(): void
    {
        $code = Code::factory()->create();

        $data = [
            'code' => $this->faker->url(),
            'has_card' => $this->faker->boolean(),
        ];

        $response = $this->putJson(route('api.codes.update', $code), $data);

        $data['id'] = $code->id;

        $this->assertDatabaseHas('codes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_code(): void
    {
        $code = Code::factory()->create();

        $response = $this->deleteJson(route('api.codes.destroy', $code));

        $this->assertModelMissing($code);

        $response->assertNoContent();
    }
}
