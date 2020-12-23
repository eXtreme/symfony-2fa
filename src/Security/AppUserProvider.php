<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AppUserProvider implements UserProviderInterface
{
    public const TOTP_SECRET_DEMO = '45YHJZK3QCY2CVJ5SGUJWCBJXLJ23D25IFAPE6I2CVPKX6BMLUYQ';

    public function loadUserByUsername(string $username)
    {
        $exception = new UsernameNotFoundException();
        $exception->setUsername($username);

        if ($username !== 'demo') {
            throw $exception;
        }

        $appUser = AppUser::fromData([
            'username' => 'demo',
            'password' => 'demo',
            'totpSecret' => self::TOTP_SECRET_DEMO,
        ]);

        return $appUser;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', \get_class($user))
            );
        }

        $exception = new UsernameNotFoundException();
        $exception->setUsername($user->getUsername());

        if ($user->getUsername() !== 'demo') {
            throw $exception;
        }

        $appUser = AppUser::fromData([
            'username' => 'demo',
            'password' => 'demo',
            'totpSecret' => self::TOTP_SECRET_DEMO,
        ]);

        return $appUser;
    }

    public function supportsClass(string $class)
    {
        return AppUser::class === $class;
    }
}
