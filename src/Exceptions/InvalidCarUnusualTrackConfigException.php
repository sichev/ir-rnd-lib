<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;
use Sichev\IrRndLib\Car;
use Sichev\IrRndLib\Types;

class InvalidCarUnusualTrackConfigException extends Exception
{
    /**
     * @param array $configs
     * @param Car $car
     */
    public function __construct(array $configs, Car $car)
    {
        parent::__construct("Invalid Unusual tracks configuration '" . json_encode($configs) . "'. Car: " . json_encode($car));
    }
}