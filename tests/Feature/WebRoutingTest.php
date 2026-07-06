<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Bug;

class WebRoutingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test home page loads correctly.
     */
    public function test_home_page_returns_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Bug Priority');
    }

    /**
     * Test materi page loads correctly.
     */
    public function test_materi_page_returns_successful_response(): void
    {
        $response = $this->get('/materi');

        $response->assertStatus(200);
        $response->assertSeeText('Logika Fuzzy');
    }

    /**
     * Test simulasi page loads correctly.
     */
    public function test_simulasi_page_returns_successful_response(): void
    {
        $response = $this->get('/simulasi');

        $response->assertStatus(200);
        $response->assertSeeText('Simulasi');
    }

    /**
     * Test simulasi calculation.
     */
    public function test_simulasi_calculation_works(): void
    {
        $response = $this->post('/simulasi', [
            'severity' => 75,
            'impact' => 80,
            'affected_users' => 70,
        ]);

        $response->assertStatus(200);
        $response->assertSeeText('Mamdani');
        $response->assertSeeText('Sugeno');
        $response->assertSeeText('Tsukamoto');
    }

    /**
     * Test perbandingan page loads correctly.
     */
    public function test_perbandingan_page_returns_successful_response(): void
    {
        $response = $this->get('/perbandingan');

        $response->assertStatus(200);
        $response->assertSeeText('Perbandingan');
    }

    /**
     * Test tentang page loads correctly.
     */
    public function test_tentang_page_returns_successful_response(): void
    {
        $response = $this->get('/tentang');

        $response->assertStatus(200);
        $response->assertSeeText('Tentang');
    }

    /**
     * Test history page loads correctly.
     */
    public function test_history_page_returns_successful_response(): void
    {
        // Insert a dummy bug to test history display
        Bug::create([
            'severity' => 50,
            'impact' => 50,
            'affected_users' => 50,
            'mamdani_score' => 50,
            'mamdani_label' => 'Medium',
            'sugeno_score' => 50,
            'sugeno_label' => 'Medium',
            'tsukamoto_score' => 50,
            'tsukamoto_label' => 'Medium',
        ]);

        $response = $this->get('/history');

        $response->assertStatus(200);
        $response->assertSee('Riwayat Simulasi');
    }
}
