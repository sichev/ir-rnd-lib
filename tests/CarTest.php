<?php

namespace Sichev\IrRndLib\Tests;

use Sichev\IrRndLib\Car;
use PHPUnit\Framework\TestCase;
use Sichev\IrRndLib\Exceptions\InvalidCarGroupException;
use Sichev\IrRndLib\Exceptions\InvalidCarNameException;
use Sichev\IrRndLib\Exceptions\InvalidCarTrackConfigException;
use Sichev\IrRndLib\Exceptions\InvalidCarTypeException;
use Sichev\IrRndLib\Exceptions\InvalidCarUnusualTrackConfigException;

class CarTest extends TestCase
{
    private object $initialCar;

    public function setUp(): void
    {
        parent::setUp();
        $this->initialCar = (object) [
            "type" => "Formula Car",
            "name" => "Ray FF1600",
            "group" => null,
            "included" => true,
            "disabled" => false,
            "popular" => true,
            "legacy" => false,
            "configs" => [
                "Fast Road",
                "Medium Road",
                "Slow Road",
            ],
            "unusualConfigs" => [
                "Long Oval",
                "Short Oval",
            ]
        ];
    }

    public function testWrongType()
    {
        $car = clone $this->initialCar;
        $car->type = "Formila ZZZ";
        $this->expectException(InvalidCarTypeException::class);
        Car::make($car);
    }

    public function testWrongName()
    {
        $car = clone $this->initialCar;
        $car->name = "";
        $this->expectException(InvalidCarNameException::class);
        Car::make($car);
    }

    public function testWrongGroup()
    {
        $car = clone $this->initialCar;
        $car->group = "FAKE";
        $this->expectException(InvalidCarGroupException::class);
        Car::make($car);
    }


    public function testValidConfigs()
    {
        $car = clone $this->initialCar;
        $car->configs = ["Long Oval", "Short Oval", "Fake Oval"];
        $this->expectException(InvalidCarTrackConfigException::class);
        Car::make($car);
    }

    public function testValidUnusualConfigs()
    {
        $car = clone $this->initialCar;
        $car->unusualConfigs = ["Long Oval", "Short Oval", "Fake Oval"];
        $this->expectException(InvalidCarUnusualTrackConfigException::class);
        Car::make($car);
    }


    public function testGetConfigs()
    {
        $carData = clone $this->initialCar;
        $carData->configs = ["Long Oval", "Short Oval"];
        $carData->unusualConfigs = ["Legends Oval"];
        $car = Car::make($carData);
        $configs = $car->getConfigs();

        $this->assertcontains("Long Oval", $configs);
        $this->assertcontains("Short Oval", $configs);
        $this->assertNotContains("Legends Oval", $configs);
        $this->assertCount(2, $configs);
    }

    public function testGetConfigs2()
    {
        $carData = clone $this->initialCar;
        $carData->configs = ["Long Oval", "Short Oval"];
        $carData->unusualConfigs = ["Legends Oval"];
        $car = Car::make($carData);
        $car->setUseUnusualConfigs(true);
        $configs = $car->getConfigs();

        $this->assertcontains("Long Oval", $configs);
        $this->assertcontains("Short Oval", $configs);
        $this->assertContains("Legends Oval", $configs);
        $this->assertCount(3, $configs);
    }
}
