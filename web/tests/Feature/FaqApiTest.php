<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FaqApiTest extends TestCase
{
    /**
     * Тест получения списка FAQ-ов.
     *
     * @return void
     */
    public function testFaqsList(): void
    {
        $response = $this->getJson('api/faqs');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'description',
                ]
            ]);
    }
}
