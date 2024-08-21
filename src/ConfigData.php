<?php

namespace Sichev\IrRndLib;

use Sichev\IrRndLib\Exceptions\CarIsNotAProperInstanceException;
use Sichev\IrRndLib\Exceptions\CarsListIsEmptyException;
use Sichev\IrRndLib\Exceptions\EmptyListOfTrackConfigsException;
use Sichev\IrRndLib\Exceptions\EmptyTrackNameException;
use Sichev\IrRndLib\Exceptions\InvalidCarGroupException;
use Sichev\IrRndLib\Exceptions\InvalidCarNameException;
use Sichev\IrRndLib\Exceptions\InvalidCarTrackConfigException;
use Sichev\IrRndLib\Exceptions\InvalidCarTypeException;
use Sichev\IrRndLib\Exceptions\InvalidCarUnusualTrackConfigException;
use Sichev\IrRndLib\Exceptions\InvalidTrackConfigNameException;
use Sichev\IrRndLib\Exceptions\InvalidTrackConfigTypeException;
use Sichev\IrRndLib\Exceptions\TrackIsNotAProperInstanceException;
use Sichev\IrRndLib\Exceptions\TracksListIsEmptyException;

readonly class ConfigData
{
    /**
     * @param Car[] $cars
     * @param Track[] $tracks
     * @throws CarIsNotAProperInstanceException
     * @throws TrackIsNotAProperInstanceException
     */
    public function __construct(
        public array $cars,
        public array $tracks,
    ) {
        $this->validate();
    }

    /**
     * @throws CarIsNotAProperInstanceException
     * @throws TrackIsNotAProperInstanceException
     */
    private function validate(): void
    {
        foreach ($this->cars as $car)
            if (!$car instanceof Car)
                throw new CarIsNotAProperInstanceException($car);

        foreach ($this->tracks as $track)
            if (!$track instanceof Track)
                throw new TrackIsNotAProperInstanceException($track);

    }

    /**
     * @throws CarIsNotAProperInstanceException
     * @throws CarsListIsEmptyException
     * @throws EmptyListOfTrackConfigsException
     * @throws EmptyTrackNameException
     * @throws InvalidCarGroupException
     * @throws InvalidCarNameException
     * @throws InvalidCarTrackConfigException
     * @throws InvalidCarTypeException
     * @throws InvalidCarUnusualTrackConfigException
     * @throws InvalidTrackConfigNameException
     * @throws InvalidTrackConfigTypeException
     * @throws TrackIsNotAProperInstanceException
     * @throws TracksListIsEmptyException
     */
    public static function make(string $configPath): self
    {
        $data = json_decode(file_get_contents($configPath));
        $cars = [];
        if (!is_array($data?->cars) or empty($data?->cars))
            throw new CarsListIsEmptyException($data?->cars);
        foreach ($data->cars as $car) {
            $cars[] = Car::make($car);
        }

        $tracks = [];
        if (!is_array($data?->tracks) or empty($data?->tracks))
            throw new TracksListIsEmptyException($data?->tracks);
        foreach ($data->tracks as $track) {
            $tracks[] = Track::make($track);
        }

        return new self($cars, $tracks);
    }

    public static function configPath(): string
    {
        return "configs/config.json";
    }
}