<?php 

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

// esta interfaz lo que va a permitir es que cuando creemos nuestro UserProvider
// el framework sepa que esta clase User es la clase que representa a los usuarios en mi app.
class User implements UserInterface
{
    private string $id;
    private string $name;
    private string $email;
    private string $password;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct(string $name, string $email, string $password) {
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->setEmail($email);
        $this->password = $password;
        $this->createdAt = new \DateTime();
        $this->markAsUpdated();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        if (!\filter_var(trim($email), \FILTER_VALIDATE_EMAIL)) {
            throw new \LogicException('Invalid email');
        }

        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function markAsUpdated(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getRoles(): array
    {
        return [];
    }

    public function getSalt(): void
    {
        
    }

    public function getUsername(): string
    {
        // esto es porque nuestro UserProvider va ha hacer uso este mètodo que implementa la interfaz
        // para obtener el campo porque queremos identificar al usuario.
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        
    }

    public function getUserIdentifier(): void
    {
        
    }

}