<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Cliente;

use App\Domain\Cliente\Cliente;
use App\Domain\Cliente\ClienteNotFoundException;
use App\Domain\Cliente\ClienteRepository;
use PhpParser\Node\Stmt\Interface_;

class InMemoryClienteRepository implements ClienteRepository
{
    /**
     * @var Cliente[]
     */
    private array $clientesPDO;
    private $con;

    /**
     * @param Cliente[]|null $clientesPDO
     */
    public function __construct(ContainerInterface $c,  array $clientesPDO = null)

    {
        $this->con = $c->get('pdo_bd');
        // $this->Clientes = $Clientes ?? [
        //     1 => new Cliente(1, '------bill.gates', 'Bill', 'Gates'),
        //     2 => new Cliente(2, '-- steve.jobs', 'Steve', 'Jobs'),
        //     3 => new Cliente(3, '45 mark.zuckerberg', 'Mark', 'Zuckerberg'),
        //     4 => new Cliente(4, '87 evan.spiegel', 'Evan', 'Spiegel'),
        //     5 => new Cliente(5, '99 jack.dorsey', 'Jack', 'Dorsey'),
        // ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->Clientes);
    }

    /**
     * {@inheritdoc}
     */
    public function findClienteOfId(int $id): Cliente
    {
        if (!isset($this->Clientes[$id])) {
            throw new ClienteNotFoundException();
        }

        return $this->Clientes[$id];
    }
}
