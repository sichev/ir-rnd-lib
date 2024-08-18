<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;
use Sichev\IrRndLib\Car;
use Sichev\IrRndLib\Types;

class InvalidCarNameException extends Exception
{
    public function __construct(?string $carType, Car $car)
    {
        parent::__construct("Invalid car Name '$carType'. Car: " . json_encode($car));
    }
}