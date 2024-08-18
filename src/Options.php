<?php

namespace Sichev\IrRndLib;

use Sichev\IrRndLib\Exceptions\InvalidCarTypeException;

readonly class Options
{
    /**
     * @throws InvalidCarTypeException
     */
    public function __construct(
        public bool    $onlyIncluded = true,
        public ?string $car = null,
        public bool    $allowDisabled = false,
        public bool    $allowUnusualConfigs = false,
    ) {
        if (!in_array($car, [null, ...Types::URL_CAR_TYPES], true))
            throw new InvalidCarTypeException($car);
    }

    /**
     * @throws InvalidCarTypeException
     */
    public static function make(
        bool $onlyIncluded = true,
        ?string $car = null,
        bool $allowDisabled = false,
        bool $allowUnusualConfigs = false,
    ): Options
    {
        if ($car === 'any')
            $car = null;

        return new self($onlyIncluded, $car, $allowDisabled, $allowUnusualConfigs);
    }
}
