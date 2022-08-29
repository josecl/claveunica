<?php

declare(strict_types=1);

namespace Josecl\ClaveUnica;

use SocialiteProviders\Manager\SocialiteWasCalled;

class ClaveUnicaExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled): void
    {
        $socialiteWasCalled->extendSocialite('claveunica', ClaveUnicaProvider::class);
    }
}
