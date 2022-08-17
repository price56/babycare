<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use RefreshDatabase;

    private User|null $user;

    protected const PASSWORD = 'password1234';
    protected const MISS_PASSWORD = 'miss-password1234';
    protected const SHORT_PASSWORD = 'short';

    protected function user(): User
    {
        if (!empty($this->user)) {
            return $this->user;
        }

        $this->user = User::latest()->first();

        if (!$this->user) {
            $this->user = User::factory()->create();
        }

        return $this->user;
    }

    protected function successLoginData($data): array
    {
        return [
            'password' => self::PASSWORD,
            ...$data,
        ];
    }

    protected function failLoginData($data): array
    {
        return [
            'password' => self::MISS_PASSWORD,
            ...$data,
        ];
    }

    protected function email(): array
    {
        return ['email' => $this->user()->email];
    }

    protected function mobile(): array
    {
        return ['mobile' => $this->user()->mobile];
    }

    protected function loginClient(): TestCase
    {
        $response = $this->postJson(route('auth.login'), $this->successLoginData($this->mobile()));
        $data = $response->json();

        return $this->withHeaders([
            'Authorization' => 'Bearer ' . $data['access_token'],
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }
}
