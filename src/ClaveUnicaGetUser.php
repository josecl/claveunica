<?php

declare(strict_types=1);

namespace Josecl\ClaveUnica;

use Exception;
use Laravel\Socialite\Facades\Socialite;

class ClaveUnicaGetUser
{
    public function user(): object
    {
        try {
            $user = Socialite::driver('claveunica')->user();
        } catch (Exception $exception) {
            report($exception);

            throw new ClaveUnicaException('El acceso vía ClaveÚnica no fue autorizado.', previous: $exception);
        }

        return $user;
    }
}
