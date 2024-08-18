<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;
use Sichev\IrRndLib\Types;

class InvalidInputCarTypeException extends Exception
{
    public function __construct(?string $carType)
    {
        $validTypes = join(',', Types::URL_CAR_TYPES);
        parent::__construct("Invalid car type: '$carType' Should be one of this or 'null': $validTypes.");
    }
}