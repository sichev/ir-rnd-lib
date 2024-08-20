<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;
use Sichev\IrRndLib\Track;

class EmptyListOfTrackConfigsException extends Exception
{
    public function __construct(Track $track)
    {
        parent::__construct("Empty list of configs for track. Track: " . json_encode($track));
    }
}