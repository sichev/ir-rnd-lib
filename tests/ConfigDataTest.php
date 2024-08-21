<?php

namespace Sichev\IrRndLib\Tests;

use Sichev\IrRndLib\Car;
use Sichev\IrRndLib\ConfigData;
use PHPUnit\Framework\TestCase;
use Sichev\IrRndLib\Exceptions\CarIsNotAProperInstanceException;
use Sichev\IrRndLib\Exceptions\CarsListIsEmptyException;
use Sichev\IrRndLib\Exceptions\TrackIsNotAProperInstanceException;
use Sichev\IrRndLib\Exceptions\TracksListIsEmptyException;
use Sichev\IrRndLib\Track;
use Sichev\IrRndLib\TrackConfig;

class ConfigDataTest extends TestCase
{
    public function testConfigData()
    {
        $configData = ConfigData::make(ConfigData::configPath());
        $this->assertNotEmpty($configData->cars);
        $this->assertNotEmpty($configData->tracks);
        self::assertInstanceOf(Car::class, $configData->cars[0]);
        self::assertInstanceOf(Track::class, $configData->tracks[0]);
    }

    public function testEmptyCarsConfigData()
    {
        $path = "tests/testsData/no_cars_config.json";
        $this->expectException(CarsListIsEmptyException::class);
        ConfigData::make($path);
    }

    public function testEmptyTracksConfigData()
    {
        $path = "tests/testsData/no_tracks_config.json";
        $this->expectException(TracksListIsEmptyException::class);
        ConfigData::make($path);
    }

    public function testBadCarsConfigData()
    {
        $cars[] = (object) ["data" => "fake object"];
        $tracks[] = new Track("Car", false, false, false, false,
            [new TrackConfig("track", "Fast Road", [], [], false)]);
        $this->expectException(CarIsNotAProperInstanceException::class);
        new ConfigData($cars, $tracks);
    }

    public function testBadTracksConfigData()
    {
        $tracks[] = (object) ["data" => "fake object"];
        $cars[] = new Car("Prototypes", "Acura ARX-06 GTP", "GTP", false, false,
            false, false, ["Fast Road"], []);
        $this->expectException(TrackIsNotAProperInstanceException::class);
        new ConfigData($cars, $tracks);
    }
}
