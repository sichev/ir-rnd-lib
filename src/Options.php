<?php

namespace Sichev\IrRndLib;

use Sichev\IrRndLib\Exceptions\InvalidInputCarTypeException;

readonly class Options
{
    /**
     * @throws InvalidInputCarTypeException
     */
    public function __construct(
        public bool    $onlyIncluded = true,
        public ?string $car = null,
        public bool    $allowDisabled = false,
        public bool    $allowUnusualConfigs = false,
    ) {
        if (!in_array($car, [null, ...Types::URL_CAR_TYPES], true))
            throw new InvalidInputCarTypeException($car);
    }

    /**
     * @throws InvalidInputCarTypeException
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
