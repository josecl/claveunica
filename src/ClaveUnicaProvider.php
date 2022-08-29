<?php

declare(strict_types=1);

namespace Josecl\ClaveUnica;

use Exception;
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

    /**
     * @throws ClaveUnicaException
     */
    protected function getUserByToken($token): array
    {
        $url = config('services.claveunica.user_uri');

        try {
            $response = $this->getHttpClient()->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $exception) {
            throw new ClaveUnicaException('ClaveÚnica getUserByToken fallido: ' . $exception->getMessage(), previous: $exception);
        }
    }

    protected function mapUserToObject(array $user): User
    {
        try {
            return (new User())->setRaw($user)->map([
                'id' => $user['RolUnico']['numero'],
                'name' => $user['name'],
                'first_name' => implode(' ', $user['name']['nombres']),
                'last_name' => implode(' ', $user['name']['apellidos']),
                'run' => $user['RolUnico']['numero'],
                'dv' => $user['RolUnico']['DV'],
            ]);
        } catch (Exception $exception) {
            throw new ClaveUnicaException('ClaveÚnica datos de User inválidos: ' . $exception->getMessage(), previous: $exception);
        }
    }
}
