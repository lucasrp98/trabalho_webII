<?php
declare(strict_types=1);

namespace App\Domain\Cliente;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ClienteNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The Cliente you requested does not exist.';
}
