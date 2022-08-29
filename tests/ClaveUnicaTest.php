<?php

declare(strict_types=1);


use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Response as GuzzleHttpResponse;
use Josecl\ClaveUnica\ClaveUnicaException;
use Josecl\ClaveUnica\ClaveUnicaGetUser;
use Laravel\Socialite\Facades\Socialite;

beforeEach(function () {
    config(['claveunica.autologin' => true]);
});



test('redirect', function () {
    $redirect = Socialite::driver('claveunica')->stateless()->redirect();

    expect($redirect)
        ->toBeInstanceOf(Illuminate\Http\RedirectResponse::class)
        ->getTargetUrl()->toStartWith(config('services.claveunica.auth_uri'))
    ;
});



test('user', function () {
    $user = [
        'RolUnico' => [
            'numero' => '44444444',
            'DV' => '4',
        ],
        'name' => [
            'nombres' => ['José', 'Antonio'],
            'apellidos' => ['Rodríguez', 'Valderrama'],
        ],
    ];

    Mockery::mock('overload:' . GuzzleHttpClient::class)
        ->shouldReceive('post')
        ->withSomeOfArgs(config('services.claveunica.token_uri'))
        ->andReturn(new GuzzleHttpResponse(
            body: json_encode([
                'access_token' => '::access-token::',
                'token_type' => 'Bearer',
                'expires_in' => 3600,
            ], JSON_THROW_ON_ERROR),
        ))
        ->shouldReceive('post')
        ->withSomeOfArgs(config('services.claveunica.user_uri'))
        ->andReturn(new GuzzleHttpResponse(
            body: json_encode($user, JSON_THROW_ON_ERROR)
        ));

    Socialite::driver('claveunica')->stateless();

    $claveUnicaUser = app(ClaveUnicaGetUser::class)->user();

    expect($claveUnicaUser)
        ->user->toBe($user)
        ->id->toBe('44444444')
        ->run->toBe('44444444')
        ->dv->toBe('4')
        ->first_name->toBe('José Antonio')
        ->last_name->toBe('Rodríguez Valderrama')
    ;
});

test('user failed', function () {
    Mockery::mock('overload:' . GuzzleHttpClient::class)
        ->shouldReceive('post')
        ->withSomeOfArgs(config('services.claveunica.token_uri'))
        ->andReturn(new GuzzleHttpResponse(
            body: json_encode([
                'access_token' => '::access-token::',
                'token_type' => 'Bearer',
                'expires_in' => 3600,
            ], JSON_THROW_ON_ERROR),
        ))
        ->shouldReceive('post')
        ->withSomeOfArgs(config('services.claveunica.user_uri'))
        ->andReturn(new GuzzleHttpResponse(
            401
        ))
    ;

    Socialite::driver('claveunica')->stateless();

    test()->expectException(ClaveUnicaException::class);

    app(ClaveUnicaGetUser::class)->user();
});
