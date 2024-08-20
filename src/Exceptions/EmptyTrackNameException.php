<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;
use Sichev\IrRndLib\Track;

class EmptyTrackNameException extends Exception
{
    public function __construct(Track $track)
    {
        parent::__construct("Empty Track Name. Track: " . json_encode($track));
    }
}