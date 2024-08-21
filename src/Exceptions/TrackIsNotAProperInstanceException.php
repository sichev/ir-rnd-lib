<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;

class TrackIsNotAProperInstanceException extends Exception
{
    public function __construct(mixed $track)
    {
        parent::__construct("Track must be an instance of Car. " . json_encode($track));
    }
}