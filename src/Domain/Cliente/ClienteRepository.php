<?php
declare(strict_types=1);

namespace App\Domain\Cliente;

interface ClienteRepository
{
    /**
     * @return Cliente[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Cliente
     * @throws ClienteNotFoundException
     */
    public function findClienteOfId(int $id): Cliente;
}
