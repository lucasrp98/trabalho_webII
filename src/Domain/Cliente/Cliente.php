<?php
declare(strict_types=1);

namespace App\Domain\Cliente;

use JsonSerializable;

class Cliente implements JsonSerializable
{
    private ?int $id;

    private string $Clientename;

    private string $firstName;

    private string $lastName;

    public function __construct(?int $id, string $Clientename, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->Clientename = strtolower($Clientename);
        $this->firstName = ucfirst($firstName);
        $this->lastName = ucfirst($lastName);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientename(): string
    {
        return $this->Clientename;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'Clientename' => $this->Clientename,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }
}
