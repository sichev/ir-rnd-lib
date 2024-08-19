<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;
use Sichev\IrRndLib\Car;
use Sichev\IrRndLib\TrackConfig;
use Sichev\IrRndLib\Types;

class InvalidTrackConfigTypeException extends Exception
{
    public function __construct(string $trackConfigType, TrackConfig $trackConfig)
    {
        parent::__construct("Invalid Track config Name '$trackConfigType'. Track Config: " . json_encode($trackConfig));
    }
}