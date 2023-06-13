<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_empty_fields()
    {
        $response = $this->post('/api/register/', []);
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'error' => true,
            'data' => [
                'name' => [
                    0 => true
                ],
                'password' => [
                    0 => true
                ],
                'email' => [
                    0 => true
                ]
            ]
        ]);
    }


    public function test_invalid_email()
    {
        $response = $this->post('/api/register/', [
            'name' => 'test',
            'password' => 'test',
            'email' => 'test'
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'error' => true,
            'data' => [
                'email' => [
                    0 => true
                ]
            ]
        ]);
    }


    public function test_duplicate_email()
    {
        $response = $this->post('/api/register/', [
            'name' => 'asd',
            'password' => 'qwe',
            'email' => 'gera.sukhomlin01@mail.ru'
        ]);
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'error' => true,
            'data' => [
                'email' => [
                    0 => true
                ]
            ]
        ]);
    }

    public function test_valid_fields()
    {
        $login = Str::random(6);
        $password = Str::random(6);
        $email = Str::random(10) . '@gmail.com'; // TODO: Придумать более адекватный тест
        $response = $this->post('/api/register/', [
            'name' => $login,
            'password' => $password,
            'email' => $email
        ]);

        $response->assertOk();

        $userId = $response['data']['id'];
        $response->assertJson([
            'data' => [
                'id' => true
            ]
        ]);

        $user = \App\Models\User::find($userId);
        $user->delete();
    }
}
