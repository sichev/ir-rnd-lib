<?php

namespace Sichev\IrRndLib;

use Sichev\IrRndLib\Exceptions\InvalidCarGroupException;
use Sichev\IrRndLib\Exceptions\InvalidCarNameException;
use Sichev\IrRndLib\Exceptions\InvalidCarTrackConfigException;
use Sichev\IrRndLib\Exceptions\InvalidCarTypeException;
use Sichev\IrRndLib\Exceptions\InvalidCarUnusualTrackConfigException;

class Car
{
    private bool $useUnusualConfigs = false;

    /**
     * @param string[] $configs
     * @param string[] $unusualConfigs
     * @throws InvalidCarGroupException
     * @throws InvalidCarNameException
     * @throws InvalidCarTrackConfigException
     * @throws InvalidCarTypeException
     * @throws InvalidCarUnusualTrackConfigException
     */
    public function __construct(
        public readonly string $type,
        public readonly string $name,
        public readonly ?string $group,
        public readonly bool $included,
        public readonly bool $disabled,
        public readonly bool $popular,
        public readonly bool $legacy,
        public readonly array $configs,
        public readonly array $unusualConfigs,
    ){
        $this->validate();
    }

    /**
     * @throws InvalidCarNameException
     * @throws InvalidCarTypeException
     * @throws InvalidCarUnusualTrackConfigException
     * @throws InvalidCarGroupException
     * @throws InvalidCarTrackConfigException
     */
    public static function make(object $car): Car
    {
        return new self(
            $car->type,
            $car->name,
            $car->group,
            $car->included,
            $car->disabled,
            $car->popular,
            $car->legacy,
            $car->configs,
            $car->unusualConfigs,
        );
    }

    /**
     * @throws InvalidCarGroupException
     * @throws InvalidCarNameException
     * @throws InvalidCarTrackConfigException
     * @throws InvalidCarTypeException
     * @throws InvalidCarUnusualTrackConfigException
     */
    protected function validate(): void
    {
        if (!in_array($this->type, Types::CAR_TYPES))
            throw new InvalidCarTypeException($this->type, $this);
        if (empty($this->name))
            throw new InvalidCarNameException($this->name, $this);
        if (is_string($this->group) && !in_array($this->group, Types::CAR_GROUPS))
            throw new InvalidCarGroupException($this->group, $this);
        if (count(array_intersect(Types::CONFIGS, $this->configs)) != count($this->configs))
            throw new InvalidCarTrackConfigException($this->configs, $this);
        if (!empty($this->unusualConfigs) && (count(array_intersect(Types::CONFIGS, $this->unusualConfigs)) != count($this->unusualConfigs)))
            throw new InvalidCarUnusualTrackConfigException($this->unusualConfigs, $this);
    }

    public function setUseUnusualConfigs(bool $use = true): self
    {
        $this->useUnusualConfigs = $use;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getConfigs(): array
    {
        $configs = $this->useUnusualConfigs ? [...$this->configs, ...$this->unusualConfigs] : $this->configs;
        return array_unique($configs);
    }
}