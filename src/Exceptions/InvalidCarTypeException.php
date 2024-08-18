<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;
use Sichev\IrRndLib\Types;

class InvalidCarTypeException extends Exception
{
    public function __construct(?string $carName)
    {
        $validTypes = join(',', Types::URL_CAR_TYPES);
        parent::__construct("Invalid car type: '$carName' Should be one of this or 'null': $validTypes.");
    }
}