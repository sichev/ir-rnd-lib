<?php

namespace Sichev\IrRndLib\Tests;

use Sichev\IrRndLib\ConfigData;
use Sichev\IrRndLib\Options;
use Sichev\IrRndLib\Randomizer;
use PHPUnit\Framework\TestCase;

class RandomizerTest extends TestCase
{
    public function testDefaultRandomizer()
    {
        $options = Options::make();
        $data = ConfigData::make(ConfigData::configPath());
        $randomizer = new Randomizer($data, $options);
        $result = $randomizer->random();
        $this->validateResult($result);
    }

    public function testCarSpecificRandomizer()
    {
        $options = Options::make(car: "sportscar");
        $data = ConfigData::make(ConfigData::configPath());
        $randomizer = new Randomizer($data, $options);
        $result = $randomizer->random();
        $this->validateResult($result);
    }


    public function testUnusualRandomizer()
    {
        $options = Options::make(allowUnusualConfigs: true);
        $data = ConfigData::make(ConfigData::configPath());
        $randomizer = new Randomizer($data, $options);
        $result = $randomizer->random();
        $this->validateResult($result);
    }

    private function validateResult(mixed $result): void
    {
        $this->assertIsObject($result);
        $this->assertTrue(property_exists($result, 'track'));
        $this->assertNotEmpty($result->track);
        $this->assertTrue(property_exists($result, 'layout'));
        $this->assertNotEmpty($result->layout);
        $this->assertTrue(property_exists($result, 'type'));
        $this->assertNotEmpty($result->type);
        $this->assertTrue(property_exists($result, 'car'));
        $this->assertNotEmpty($result->car);
        $this->assertTrue(property_exists($result, 'car_group'));
    }
}
