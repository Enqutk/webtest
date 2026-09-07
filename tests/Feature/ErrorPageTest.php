<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ErrorPageTest extends TestCase
{
    public function test_missing_page_renders_custom_404(): void
    {
        $this->get('/this-page-does-not-exist-404')
            ->assertNotFound()
            ->assertSee('404', false)
            ->assertSee('This page is not on the map')
            ->assertSee('Back home');
    }

    public function test_card_profile_404_offers_profile_return_link(): void
    {
        $this->get('/card/demo-profile/missing-page')
            ->assertNotFound()
            ->assertSee('Back to profile')
            ->assertSee('/card/demo-profile', false);
    }

    public function test_server_error_renders_custom_500_when_debug_is_off(): void
    {
        config(['app.debug' => false]);

        Route::get('/__test-500', function () {
            abort(500);
        });

        $this->get('/__test-500')
            ->assertStatus(500)
            ->assertSee('500', false)
            ->assertSee('Something went wrong on our side')
            ->assertSee('Back home');
    }
}
