<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;
use Sichev\IrRndLib\Car;
use Sichev\IrRndLib\TrackConfig;
use Sichev\IrRndLib\Types;

class InvalidTrackConfigNameException extends Exception
{
    public function __construct(string $trackConfigName, TrackConfig $trackConfig)
    {
        parent::__construct("Invalid Track config Name '$trackConfigName'. Track Config: " . json_encode($trackConfig));
    }
}