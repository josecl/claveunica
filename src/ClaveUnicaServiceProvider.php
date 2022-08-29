<?php

declare(strict_types=1);

namespace Josecl\ClaveUnica;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class ClaveUnicaServiceProvider extends ServiceProvider
{
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            \Josecl\ClaveUnica\ClaveUnicaExtendSocialite::class . '@handle',
        ],
    ];
}
