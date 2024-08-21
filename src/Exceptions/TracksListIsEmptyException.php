<?php

namespace Sichev\IrRndLib\Exceptions;

use Exception;
use Sichev\IrRndLib\Car;

class TracksListIsEmptyException extends Exception
{
    public function __construct(mixed $list)
    {
        parent::__construct("Tracks list is empty. " . json_encode($list));
    }
}