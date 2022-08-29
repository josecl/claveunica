<?php

declare(strict_types=1);

namespace Josecl\ClaveUnica;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class ClaveUnicaProvider extends AbstractProvider
{
    /** Unique Provider Identifier. */
    public const IDENTIFIER = 'CLAVEUNICA';

    protected $scopes = [
        'openid',
        'run',
        'name',
    ];

    protected $scopeSeparator = ' ';

    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase(config('services.claveunica.auth_uri'), $state);
    }

    protected function getTokenUrl(): string
    {
        return config('services.claveunica.token_uri');
    }

    protected function getUserByToken($token): array
    {
        $response = $this->getHttpClient()->post(config('services.claveunica.user_uri'), [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        if ($response->getStatusCode() >= 400) {
            throw new ClaveUnicaException('Request de user a ' . config('services.claveunica.user_uri') . ' con HTTP status ' . $response->getStatusCode());
        }

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['RolUnico']['numero'],
            'name' => $user['name'],
            'first_name' => implode(' ', $user['name']['nombres']),
            'last_name' => implode(' ', $user['name']['apellidos']),
            'run' => $user['RolUnico']['numero'],
            'dv' => $user['RolUnico']['DV'],
        ]);
    }
}
