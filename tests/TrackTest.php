<?php

namespace Sichev\IrRndLib\Tests;

use Sichev\IrRndLib\Car;
use Sichev\IrRndLib\Exceptions\EmptyListOfTrackConfigsException;
use Sichev\IrRndLib\Exceptions\EmptyTrackNameException;
use Sichev\IrRndLib\Track;
use PHPUnit\Framework\TestCase;
use Sichev\IrRndLib\TrackConfig;

class TrackTest extends TestCase
{
    private object $initialTrack;

    protected function setup(): void
    {
        parent::setup();
        $this->initialTrack = (object) [
            "name" => "Circuit of the Americas",
            "included" => false,
            "disabled" => false,
            "popular" => false,
            "legacy" => false,
            "configs" => [
                (object) ["name" => "Grand Prix", "type" => "Fast Road", "veryLongStraights" => true, "nascarRoad" => true],
                (object) ["name" => "East", "type" => "Medium Road"],
                (object) ["name" => "Oval", "type" => "Short Oval"],
                (object) ["name" => "West", "type" => "Fast Road", "exceptions" => (object)[
                    "cars" => ["Dallara B", "BMW 316", "AUDI 1.4 Q"],
                    "groups" => ["Formula W", "BMW 1600"],
                ]],
            ],
        ];
    }

    public function testEmptyTrackName()
    {
        $trackData = clone $this->initialTrack;
        Track::make($trackData);

        $trackData->name = "";
        $this->expectException(EmptyTrackNameException::class);
        Track::make($trackData);
    }

    public function testEmptyListOfTrackConfigs()
    {
        $trackData = clone $this->initialTrack;
        Track::make($trackData);

        $trackData->configs = [];
        $this->expectException(EmptyListOfTrackConfigsException::class);
        Track::make($trackData);
    }

    public function testAvailableLayouts()
    {
        $track = Track::make(clone $this->initialTrack);
        $list = $track->getAvailableLayoutsList();
        $this->assertCount(3, $list);
        $this->assertContains("Fast Road", $list);
        $this->assertContains("Medium Road", $list);
        $this->assertContains("Short Oval", $list);
    }

    public function testCarsExceptionsList()
    {
        $track = Track::make(clone $this->initialTrack);
        $list = $track->getExceptionCarsList();
        $this->assertCount(3, $list);
        $this->assertContains("Dallara B", $list);
        $this->assertContains("BMW 316", $list);
        $this->assertContains("AUDI 1.4 Q", $list);
    }

    public function testGroupsExceptionsList()
    {
        $track = Track::make(clone $this->initialTrack);
        $list = $track->getExceptionGroupsList();
        $this->assertCount(2, $list);
        $this->assertContains("Formula W", $list);
        $this->assertContains("BMW 1600", $list);
    }

    public function testRandomConfig()
    {
        $track = Track::make(clone $this->initialTrack);
        $config = $track->getRandomConfig();
        $this->assertInstanceOf(TrackConfig::class, $config);
        $this->assertTrue(in_array($config->name, ["Grand Prix", "East", "West", "Oval"]));
    }

    public function testFilterByCar()
    {
        $track = Track::make(clone $this->initialTrack);
        $car = Car::make((object)[
            "type" => "Formula Car",
            "name" => "Ray FF1600",
            "group" => null,
            "included" => true,
            "disabled" => false,
            "popular" => true,
            "legacy" => false,
            "configs" => [
                "Medium Road",
                "Slow Road"
            ],
            "unusualConfigs" => [
                "Short Oval"
            ]
        ]);
        $track->filterTrackConfigsByCar($car);
        $this->assertCount(1, $track->configs);


        $car->setUseUnusualConfigs();
        $track2 = Track::make(clone $this->initialTrack);
        $track2->filterTrackConfigsByCar($car);
        $this->assertCount(2, $track2->configs);
    }
}
