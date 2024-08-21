<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;

class CarIsNotAProperInstanceException extends Exception
{
    public function __construct(mixed $car)
    {
        parent::__construct("Car must be an instance of Car. " . json_encode($car));
    }
}