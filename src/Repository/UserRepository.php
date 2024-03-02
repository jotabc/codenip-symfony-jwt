<?php 

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return User::class;
    }

    public function findOneByEmailOrFail(string $email): ?User
    {
        if (null === $user = $this->objectRepository->findOneBy(['email' => $email])) {
            throw new NotFoundHttpException(\sprintf('User %s not found', $email));
        }

        return $user;
    }

    /**
     * @throws ORMException
     * @return OptimisticLockException
     */
    public function save(User $user): void
    {
        $this->saveEntity($user);
    }
    
}