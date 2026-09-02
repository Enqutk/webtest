<?php

namespace Tests\Feature;

use App\Models\CardApplication;
use App\Models\Organization;
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
        $response->assertSee('Live Preview');
    }

    public function test_user_can_submit_card_application(): void
    {
        $payload = [
            'type' => 'individual',
            'name' => 'Sophia Al-Mansoor',
            'role_title' => 'Chief Investment Officer',
            'company_name' => 'Horizon Capital Group',
            'email' => 'sophia@horizon-capital.example',
            'phone' => '+971 50 123 4567',
            'tagline' => 'Global private wealth and sovereign advisory',
            'bio' => 'Advising institutional funds and executive boards across the EMEA region.',
            'card_edition' => 'brushed_gold',
            'bg_color' => '#0b0f19',
            'accent_color' => '#c5a059',
            'font_display' => 'Cinzel',
            'font_body' => 'Outfit',
            'image_shape' => 'shield',
            'highlights' => [
                'Over $1.2B in institutional capital syndicated',
                'Advisory partner to 14 multi-family offices',
            ],
            'telegram' => '@sophia_almansoor',
            'whatsapp' => '+971501234567',
        ];

        $response = $this->withoutMiddleware()->post('/apply', $payload);
        
        $app = CardApplication::where('email', 'sophia@horizon-capital.example')->first();
        $this->assertNotNull($app);
        $this->assertEquals('pending', $app->status);
        $this->assertEquals('2,450 ETB', $app->quote_amount);

        $response->assertRedirect(route('card.apply.success', ['code' => $app->reference_code]));
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
