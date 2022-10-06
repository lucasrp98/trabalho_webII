<?php
declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class ViewClienteAction extends ClienteAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $ClienteId = (int) $this->resolveArg('id');
        $Cliente = $this->ClienteRepository->findClienteOfId($ClienteId);

        $this->logger->info("Cliente of id `${ClienteId}` was viewed.");

        return $this->respondWithData($Cliente);
    }
}
