<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LanguageApiTest extends TestCase
{
    /**
     * Тест получения списка языков.
     *
     * @return void
     */
    public function testLanguagesList(): void
    {
        $response = $this->get('/api/languages');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['name', 'lang_code', 'locale', 'is_default']
            ]);
    }
}
