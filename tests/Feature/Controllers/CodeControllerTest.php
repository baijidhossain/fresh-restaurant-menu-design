<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Code;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CodeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_codes(): void
    {
        $codes = Code::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('codes.index'));

        $response
            ->assertOk()
            ->assertViewIs('admin.codes.index')
            ->assertViewHas('codes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_code(): void
    {
        $response = $this->get(route('codes.create'));

        $response->assertOk()->assertViewIs('admin.codes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_code(): void
    {
        $data = Code::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('codes.store'), $data);

        $this->assertDatabaseHas('codes', $data);

        $code = Code::latest('id')->first();

        $response->assertRedirect(route('codes.edit', $code));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_code(): void
    {
        $code = Code::factory()->create();

        $response = $this->get(route('codes.show', $code));

        $response
            ->assertOk()
            ->assertViewIs('admin.codes.show')
            ->assertViewHas('code');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_code(): void
    {
        $code = Code::factory()->create();

        $response = $this->get(route('codes.edit', $code));

        $response
            ->assertOk()
            ->assertViewIs('admin.codes.edit')
            ->assertViewHas('code');
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

        $response = $this->put(route('codes.update', $code), $data);

        $data['id'] = $code->id;

        $this->assertDatabaseHas('codes', $data);

        $response->assertRedirect(route('codes.edit', $code));
    }

    /**
     * @test
     */
    public function it_deletes_the_code(): void
    {
        $code = Code::factory()->create();

        $response = $this->delete(route('codes.destroy', $code));

        $response->assertRedirect(route('codes.index'));

        $this->assertModelMissing($code);
    }
}
