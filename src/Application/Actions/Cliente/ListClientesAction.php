<?php
declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class ListClientesAction extends ClienteAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $Clientes = $this->ClienteRepository->findAll();

        $this->logger->info("Clientes list was viewed.");

        return $this->respondWithData($Clientes);
    }
}
