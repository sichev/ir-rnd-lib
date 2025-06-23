<?php

namespace Sichev\IrRndLib;

class Randomizer
{
    /** @var Track[] $tracks */
    private array $tracks = [];
    /** @var Car[] $cars */
    private array $cars = [];
    private Options $options;

    public function __construct(ConfigData $dataset, Options $options)
    {
        $this->setDataset($dataset);
        $this->setOptions($options);
    }

    private function setOptions(Options $options): void
    {
        $this->options = $options;
    }

    private function setDataset(ConfigData $dataset): void
    {
        $this->tracks = $dataset->tracks;
        $this->cars = $dataset->cars;
    }


    public function random(): object
    {
        /*
        For Next Version:
            - Get List of Eliminated Tracks and Remove it from Tracks Roster
            - Continue Random as previously
            - When prepare a result data, include a list of Eliminated tracks
            - Update Eliminated Tracks List
            - Return Result

            For a correct realisation of this logic need to implement a storage of all last used tracks.
            This will be for a next-next version.
        */

        $this->filterContentBasedOnOptions();
        $track = $this->getRandomTrack();
        $this->filterCarsByTrack($track);
        $car = $this->getRandomCar();
        $track->filterTrackConfigsByCar($car);
        $layout = $track->getRandomConfig();

        return (object) [
            'track' => $track->name,
            'layout' => $layout->name,
            'type' =>$layout->type,
            'car' => $car->name,
            'car_group' => $car->group,
        ];
    }

    private function getRandomTrack(): Track
    {
        return Tools::getRandomElement($this->tracks);
    }

    private function getRandomCar(): Car
    {
        return Tools::getRandomElement($this->cars);

    }

    private function filterCarsByTrack(Track $track): void
    {
        $typesList = $track->getAvailableLayoutsList();
        $this->cars = array_filter($this->cars, fn($car) => array_intersect($car->getConfigs(), $typesList));
    }

    private function filterContentBasedOnOptions(): void
    {
        if ($this->options->onlyIncluded) {
            $this->tracks = array_filter($this->tracks, fn($track) => $track->included);
            $this->cars = array_filter($this->cars, fn($car) => $car->included);
        }

        if (!$this->options->allowDisabled) {
            $this->tracks = array_filter($this->tracks, fn($track) => $track->disabled === false);
            $this->cars = array_filter($this->cars, fn($car) => $car->disabled == false);
        }

        if ($this->options->car !== null) {
            $this->cars = [...array_filter($this->cars, fn($car) => preg_replace('/[^a-z]/','', strtolower((string) $car->type)) === $this->options->car)];

            $collectedCarTypes = [];
            array_walk($this->cars, function ($car) use (&$collectedCarTypes): void {
                $collectedCarTypes = array_unique([...$collectedCarTypes, ...$car->configs]);
            });

            array_walk($this->tracks, function ($track) use (&$collectedCarTypes): void {
                $track->configs = [...array_filter($track->configs, fn($trackConfig) => in_array($trackConfig->type, $collectedCarTypes))];
            });
            $this->tracks = [...array_filter($this->tracks, fn($track) => !empty($track->configs))];
        }

        if ($this->options->allowUnusualConfigs) {
            array_walk($this->cars, function ($car): void {
                /** @var Car $car */
                $car->setUseUnusualConfigs(true);
            });
        }
    }
}