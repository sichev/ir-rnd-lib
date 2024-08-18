<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;
use Sichev\IrRndLib\Car;
use Sichev\IrRndLib\Types;

class InvalidCarTrackConfigException extends Exception
{
    /**
     * @param array $configs
     * @param Car $car
     */
    public function __construct(array $configs, Car $car)
    {
        parent::__construct("Invalid tracks configuration '" . json_encode($configs) . "'. Car: " . json_encode($car));
    }
}