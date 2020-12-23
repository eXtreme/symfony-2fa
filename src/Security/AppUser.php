<?php

namespace App\Security;

use Scheb\TwoFactorBundle\Model\Totp\TotpConfiguration;
use Scheb\TwoFactorBundle\Model\Totp\TotpConfigurationInterface;
use Scheb\TwoFactorBundle\Model\Totp\TwoFactorInterface as TotpTwoFactorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AppUser implements UserInterface, TotpTwoFactorInterface
{
    private $username;
    private $password;
    private $totpSecret;

    private function __construct()
    {
    }

    public static function fromData(array $adminData): self
    {
        $self = new self();

        $self->username = $adminData['username'];
        $self->password = $adminData['password'];
        $self->totpSecret = $adminData['totpSecret'];

        return $self;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $newEncodedPassword): void
    {
        $this->password = $newEncodedPassword;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
    }

    public function isTotpAuthenticationEnabled(): bool
    {
        return true;
    }

    public function getTotpAuthenticationUsername(): string
    {
        return $this->username;
    }

    public function getTotpAuthenticationConfiguration(): ?TotpConfigurationInterface
    {
        return new TotpConfiguration($this->totpSecret, TotpConfiguration::ALGORITHM_SHA1, 30, 6);
    }
}
