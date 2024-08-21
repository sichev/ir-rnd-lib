<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;
use Sichev\IrRndLib\Car;

class CarsListIsEmptyException extends Exception
{
    public function __construct(mixed $list)
    {
        parent::__construct("Cars list is empty. " . json_encode($list));
    }
}