<?php

declare(strict_types=1);

namespace Josecl\ClaveUnica\Tests;

use Illuminate\Support\Facades\Http;
use Josecl\ClaveUnica\ClaveUnicaServiceProvider;
use SocialiteProviders\Manager\ServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            ClaveUnicaServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config([
            'services' => [
                'claveunica' => [
                    'client_id' => 'client_id',
                    'client_secret' => 'client_secret',
                    'redirect' => 'https://example.com/redirect',
                    'auth_uri' => 'https://example.com/openid/authorize',
                    'token_uri' => 'https://example.com/openid/token',
                    'user_uri' => 'https://example.com/openid/userinfo',
                ],
            ],
        ]);
    }
}
