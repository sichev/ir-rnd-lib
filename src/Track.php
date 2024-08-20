<?php

namespace Sichev\IrRndLib;

use Sichev\IrRndLib\Exceptions\EmptyListOfTrackConfigsException;
use Sichev\IrRndLib\Exceptions\EmptyTrackNameException;
use Sichev\IrRndLib\Exceptions\InvalidTrackConfigNameException;
use Sichev\IrRndLib\Exceptions\InvalidTrackConfigTypeException;

class Track
{
    /**
     * @param TrackConfig[] $configs
     * @throws EmptyListOfTrackConfigsException
     * @throws EmptyTrackNameException
     */
    public function __construct(
        public readonly string $name,
        public readonly bool $included,
        public readonly bool $disabled,
        public readonly bool $popular,
        public readonly bool $legacy,
        public array $configs,
    ) {
        $this->validate();
    }

    /**
     * @throws EmptyListOfTrackConfigsException
     * @throws EmptyTrackNameException
     * @throws InvalidTrackConfigNameException
     * @throws InvalidTrackConfigTypeException
     */
    public static function make(object $track): Track
    {
        return new self(
            $track->name,
            $track->included,
            $track->disabled,
            $track->popular,
            $track->legacy,
            TrackConfig::makeMany($track->configs),
        );
    }

    /**
     * @throws EmptyListOfTrackConfigsException
     * @throws EmptyTrackNameException
     */
    private function validate(): void
    {
        if (empty($this->name))
            throw new EmptyTrackNameException($this);
        if (empty($this->configs))
            throw new EmptyListOfTrackConfigsException($this);
    }

    /**
     * @return string[]
     */
    public function getAvailableLayoutsList(): array
    {
        $list = array_map(fn ($config) => $config->type, $this->configs);
        return array_unique($list);
    }

    /**
     * @return string[]
     */
    public function getExceptionCarsList(): array
    {
        /** @var TrackConfig $config */
        $list = array_merge(...array_map(fn ($config) => $config->carsExceptions, $this->configs));
        return array_unique($list);
    }

    /**
     * @return string[]
     */
    public function getExceptionGroupsList(): array
    {
        /** @var TrackConfig $config */
        $list = array_merge(...array_map(fn ($config) => $config->groupsExceptions, $this->configs));
        return array_unique($list);
    }

    public function filterTrackConfigsByCar(Car $car): void
    {
        $carConfigs = $car->getConfigs();
        foreach ($this->configs as $key => $config)
            if (!in_array($config->type, $carConfigs))
                unset($this->configs[$key]);
    }
    public function getRandomConfig(): TrackConfig
    {
        return Tools::getRandomElement($this->configs);
    }

}