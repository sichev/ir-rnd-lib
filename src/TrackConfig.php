<?php

namespace Sichev\IrRndLib;

use Sichev\IrRndLib\Exceptions\InvalidTrackConfigNameException;
use Sichev\IrRndLib\Exceptions\InvalidTrackConfigTypeException;

readonly class TrackConfig
{
    /**
     * @param string[] $carsExceptions
     * @param string[] $groupsExceptions
     * @throws InvalidTrackConfigNameException
     * @throws InvalidTrackConfigTypeException
     */
    public function __construct(
        public string $name,
        public string $type,
        public array $carsExceptions,
        public array $groupsExceptions,
        public bool $nascarRoad,
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidTrackConfigNameException
     * @throws InvalidTrackConfigTypeException
     */
    public static function make(object $config): TrackConfig
    {
        return new self(
            $config->name,
            $config->type,
            $config->exceptions?->cars ?? [],
            $config->exceptions?->groups ?? [],
            $config->nascarRoad ?? false,
        );
    }

    /**
     * @param object[] $configs
     * @return TrackConfig[]
     * @throws InvalidTrackConfigNameException
     * @throws InvalidTrackConfigTypeException
     */
    public static function makeMany(array $configs): array
    {
        $result = [];
        foreach ($configs as $config) {
            $result[] = self::make($config);
        }
        return  $result;
    }

    /**
     * @throws InvalidTrackConfigNameException
     * @throws InvalidTrackConfigTypeException
     */
    private function validate(): void
    {
        if (!in_array($this->type, Types::CONFIGS))
            throw new InvalidTrackConfigTypeException($this->type, $this);
        if (empty($this->name))
            throw new InvalidTrackConfigNameException($this->name, $this);
    }
}