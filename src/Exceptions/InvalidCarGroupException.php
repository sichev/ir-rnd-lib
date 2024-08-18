<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;
use Sichev\IrRndLib\Car;
use Sichev\IrRndLib\Types;

class InvalidCarGroupException extends Exception
{
    public function __construct(?string $carGroup, Car $car)
    {
        parent::__construct("Invalid car Group '$carGroup'. Car: " . json_encode($car));
    }
}