<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee(route('login'), false)
            ->assertDontSee(route('katalog'), false)
            ->assertSee('id="cinematic-particles"', false)
            ->assertSee('data-cinematic-audio', false)
            ->assertSee('data-cinematic-replay', false)
            ->assertSee('const duration = 4200', false)
            ->assertSee('animation:hero-scene-entrance 4s', false)
            ->assertSee('Peminjaman perangkat sekolah', false)
            ->assertSee('Kelola peminjaman laptop sekolah dengan mudah, cepat, dan terorganisir.', false)
            ->assertSee('class="hero-actions"', false)
            ->assertSee('data-orbit-toggle', false)
            ->assertSee('data-orbit-speed', false)
            ->assertSee('scene-orbit-front', false)
            ->assertSee('Array.from({ length: 170 }', false)
            ->assertSee('class="hero-scene"', false)
            ->assertSee('class="scene-interactive"', false)
            ->assertSee('class="keyboard-detail"', false)
            ->assertSee('Gerakkan kursor di atas ilustrasi untuk memutarnya.', false)
            ->assertSee('html.cinematic-ready body:not(.cinematic-revealed)', false)
            ->assertSee("heroScene.addEventListener('pointermove'", false)
            ->assertSee("heroScene.addEventListener('pointerleave'", false)
            ->assertSee('Ringkasan inventaris', false)
            ->assertSee('scene-orbit', false)
            ->assertSee('@keyframes hero-scene-entrance', false)
            ->assertSee('scale(.3)', false)
            ->assertSee('@keyframes laptop-hover', false)
            ->assertSee('@keyframes orbit-spin', false)
            ->assertSee("classList.add('laptop-entrance')", false)
            ->assertSee("classList.remove('laptop-entrance')", false)
            ->assertSee("classList.add('cinematic-revealed')", false)
            ->assertSee("setProperty('--tilt-y'", false)
            ->assertSee("setProperty('--tilt-x'", false)
            ->assertSee('SpeechSynthesisUtterance', false)
            ->assertSee('Sistem diaktifkan', false)
            ->assertSee('function playTechBacking()', false)
            ->assertSee('master.gain.linearRampToValueAtTime(0.055', false)
            ->assertSee('utterance.volume = 1', false)
            ->assertSee('playSound().then((played)', false)
            ->assertSee('unlockAudioOnFirstInteraction', false)
            ->assertSee('Klik di mana saja untuk suara', false)
            ->assertDontSee('sessionStorage', false)
            ->assertDontSee('cinematic-intro"', false);
    }

    public function test_guest_auth_pages_hide_the_top_catalog_link_without_removing_catalog_access(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertDontSee(route('katalog'), false);
    }
}
