<?php

namespace Tests\Feature;

use App\Models\CardApplication;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CardApplicationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_apply_page(): void
    {
        $response = $this->get('/apply');
        $response->assertStatus(200);
        $response->assertSee('Design Your NFC Smart Card');
    }

    public function test_admin_can_generate_client_invitation(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->post(route('admin.organizations.invite'), [
            'client_name' => 'Elias Vance',
            'client_email' => 'elias@vance.example',
            'client_phone' => '+251911223344',
            'initial_role' => 'Senior Partner & Strategic Advisor',
            'card_edition' => 'brushed_gold',
        ]);

        $response->assertRedirect(route('admin.organizations.create'));
        $invitation = OrganizationInvitation::where('client_email', 'elias@vance.example')->first();
        $this->assertNotNull($invitation);
        $this->assertStringStartsWith('km-', $invitation->token);
        $this->assertEquals('pending', $invitation->status);
    }

    public function test_client_can_open_invitation_link_and_submit(): void
    {
        $invitation = OrganizationInvitation::create([
            'token' => 'km-test-invite',
            'client_name' => 'Maya Lin',
            'client_email' => 'maya@lin-design.example',
            'client_phone' => '+14155552671',
            'initial_role' => 'Lead Architectural Designer',
            'card_edition' => 'brushed_gold',
            'status' => 'pending',
        ]);

        $response = $this->get('/invite/' . $invitation->token);
        $response->assertStatus(200);
        $response->assertSee('Welcome, Maya Lin!');

        $payload = [
            'invitation_token' => $invitation->token,
            'type' => 'individual',
            'name' => 'Maya Lin',
            'role_title' => 'Lead Architectural Designer',
            'company_name' => 'Maya Lin Studio',
            'email' => 'maya@lin-design.example',
            'phone' => '+14155552671',
            'tagline' => 'Creating sustainable luxury physical & digital spaces',
            'bio' => 'Award-winning architectural designer with 10+ years experience.',
            'card_edition' => 'brushed_gold',
            'bg_color' => '#0b0f19',
            'accent_color' => '#c5a059',
            'font_display' => 'Cinzel',
            'font_body' => 'Outfit',
            'image_shape' => 'arch',
            'highlights' => ['Winner of AIA 2025 Award', 'Featured in Architectural Digest'],
        ];

        $submitResponse = $this->withoutMiddleware()->post('/apply', $payload);
        
        $app = CardApplication::where('email', 'maya@lin-design.example')->first();
        $this->assertNotNull($app);
        $this->assertEquals('pending', $app->status);
        $this->assertEquals('2,450 ETB', $app->quote_amount);

        $invitation->refresh();
        $this->assertEquals('completed', $invitation->status);
        $this->assertEquals($app->id, $invitation->card_application_id);
    }

    public function test_admin_can_approve_and_provision_application(): void
    {
        $admin = User::first();

        $app = CardApplication::create([
            'reference_code' => CardApplication::generateReferenceCode(),
            'type' => 'individual',
            'name' => 'Marcus Vance',
            'slug' => 'marcus-vance',
            'email' => 'marcus@vance-holdings.example',
            'phone' => '+1 415 555 0199',
            'role_title' => 'Managing Director',
            'company_name' => 'Vance Holdings',
            'tagline' => 'Transforming scalable venture ecosystems',
            'bio' => 'Executive strategist with 15+ years experience.',
            'card_edition' => 'executive_black',
            'quote_amount' => '2,150 ETB',
            'theme' => [
                'bg' => '#090d16',
                'accent' => '#10b981',
                'font_display' => 'Outfit',
                'font_body' => 'Outfit',
                'image_shape' => 'squircle',
            ],
            'highlights' => ['Led 8 Series A financings', 'Board member of 4 tech unicorns'],
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->withoutMiddleware()->post(route('admin.applications.approve', $app));
        $response->assertRedirect(route('admin.applications.show', $app));

        $app->refresh();
        $this->assertEquals('approved', $app->status);
        $this->assertNotNull($app->organization_id);

        $org = Organization::find($app->organization_id);
        $this->assertNotNull($org);
        $this->assertEquals('Marcus Vance', $org->title);
        $this->assertEquals('active', $org->status);
    }
}
