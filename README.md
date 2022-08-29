# Emulador de ClaveÚnica - Laravel

Cliente Laravel para autenticar con servicio OAuth2 de ClaveÚnica del Gobierno de Chile.

Basado en [socialiteproviders/claveunica](https://github.com/SocialiteProviders/Providers/tree/master/src/ClaveUnica),
permite ser configurado en ambientes de desarrollo para emular el servicio de
ClaveÚnica mediante [josecl/emulador-claveunica](https://github.com/josecl/emulador-claveunica).


## Requerimientos

- Laravel 9
- php 8.0


## Instalación y configuración

Se utiliza de manera similar a los provider de [Socialite](https://socialiteproviders.com/).

Instalar dependencia:

```shell
composer require josecl/claveunica
```

Agregar configuración al archivo `config/services.php`:

```php
'claveunica' => [    
  'client_id' => env('CLAVEUNICA_CLIENT_ID'),  
  'client_secret' => env('CLAVEUNICA_CLIENT_SECRET'),  
  'redirect' => env('CLAVEUNICA_REDIRECT_URI') 
],
```

Agregar *event listener* para los eventos `SocialiteWasCalled` en tu archivo
`app/Providers/EventServiceProvider.php`:

```php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        // ...
        \Josecl\ClaveUnica\ClaveUnicaExtendSocialite::class . '@handle',
    ],
];
```


### Uso

Para redireccianar al servicio OAuth usar un contoller que haga redirect con:

```php
return Socialite::driver('claveunica')->redirect();
```

Una vez que el usuario complete el flujo de autenticación será redireccionado
a la URL definida por `CLAVEUNICA_REDIRECT_URI`.

Debes configurar un segundo controller que procese ese redirect y completar el inicio
de sesión en tu aplicación. Puedes obtener los datos del usuario autenticado
mediante este ejemplo:

```php
    $claveUnicaUser = Socialite::driver('claveunica')->user();

    dump($claveUnicaUser->run);
    dump($claveUnicaUser->dv);
    dump($claveUnicaUser->first_name);
    dump($claveUnicaUser->last_name);
```

## Emulador de ClaveÚnica

En ambientes de desarrollo puedes iniciar sesión simulando el flujo por
ClaveÚnica mediante [josecl/emulador-claveunica](https://github.com/josecl/emulador-claveunica).


Instalación:

```shell
composer require josecl/emulador-claveunica
```

Actualizar el archivo `config/services.php` con los parámetros adicionales y configurar las
variables de ambiente de acuerdo a la documentación de [josecl/emulador-claveunica](https://github.com/josecl/emulador-claveunica).

```php
'claveunica' => [    
  'client_id' => env('CLAVEUNICA_CLIENT_ID'),  
  'client_secret' => env('CLAVEUNICA_CLIENT_SECRET'),  
  'redirect' => env('CLAVEUNICA_REDIRECT_URI') 
  // Configura servicio alternativo a ClaveÚnica
  'auth_uri' => env('CLAVEUNICA_AUTH_URI', 'https://accounts.claveunica.gob.cl/openid/authorize'),
  'token_uri' => env('CLAVEUNICA_TOKEN_URI', 'https://accounts.claveunica.gob.cl/openid/token'),
  'user_uri' => env('CLAVEUNICA_USER_URI', 'https://www.claveunica.gob.cl/openid/userinfo'),
],
```
