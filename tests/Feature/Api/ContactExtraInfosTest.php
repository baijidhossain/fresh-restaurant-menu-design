<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Contact;
use App\Models\SocialLink;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactSocialLinksTest extends TestCase
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
    public function it_gets_contact_social_links(): void
    {
        $contact = Contact::factory()->create();
        $SocialLinks = SocialLink::factory()
            ->count(2)
            ->create([
                'contact_id' => $contact->id,
            ]);

        $response = $this->getJson(
            route('api.contacts.extra-infos.index', $contact)
        );

        $response->assertOk()->assertSee($SocialLinks[0]->key);
    }

    /**
     * @test
     */
    public function it_stores_the_contact_social_links(): void
    {
        $contact = Contact::factory()->create();
        $data = SocialLink::factory()
            ->make([
                'contact_id' => $contact->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.contacts.extra-infos.store', $contact),
            $data
        );

        unset($data['key']);
        unset($data['value']);
        unset($data['contact_id']);

        $this->assertDatabaseHas('social_links', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $SocialLink = SocialLink::latest('id')->first();

        $this->assertEquals($contact->id, $SocialLink->contact_id);
    }
}
