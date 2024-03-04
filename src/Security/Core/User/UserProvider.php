<?php 

declare(strict_types=1);

namespace App\Security\Core\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{

    public function __construct(
        private UserRepository $userRepository,
    ) {
        
    }

    public function loadUserByIdentifier($identifier): UserInterface
    {
        try {
            return $this->userRepository->findOneByEmailOrFail($identifier);
        } catch(NotFoundHttpException $e) {
            throw new UserNotFoundException(\sprintf('User with email %s not found', $identifier));
        }
    }

    public function loadUserByUsername($username)
    {
        
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(\sprintf('Instances of %s are not supported', \get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }
    
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        $user->setPassword($newEncodedPassword);

        $this->userRepository->save($user);
    }

    public function supportsClass(string $class): string
    {
        return User::class;
    }
}