<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Code;
use App\Models\Contact;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CodeContactsTest extends TestCase
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
    public function it_gets_code_contacts(): void
    {
        $code = Code::factory()->create();
        $contacts = Contact::factory()
            ->count(2)
            ->create([
                'code_id' => $code->id,
            ]);

        $response = $this->getJson(route('api.codes.contacts.index', $code));

        $response->assertOk()->assertSee($contacts[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_code_contacts(): void
    {
        $code = Code::factory()->create();
        $data = Contact::factory()
            ->make([
                'code_id' => $code->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route('api.codes.contacts.store', $code),
            $data
        );

        unset($data['password']);
        unset($data['email_verified_at']);

        $this->assertDatabaseHas('contacts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $contact = Contact::latest('id')->first();

        $this->assertEquals($code->id, $contact->code_id);
    }
}
