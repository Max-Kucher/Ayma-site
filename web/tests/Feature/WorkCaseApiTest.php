<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkCaseApiTest extends TestCase
{
    /**
     * Тест получения списка кейсов.
     *
     * @return void
     */
    public function testLanguagesList(): void
    {
        $response = $this->getJson('api/work-cases');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'file_path',
                    'link',
                    'name',
                    'description'
                ]
            ]);
    }
}
