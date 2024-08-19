<?php

namespace Sichev\IrRndLib\Tests;

use Sichev\IrRndLib\Exceptions\InvalidTrackConfigNameException;
use Sichev\IrRndLib\Exceptions\InvalidTrackConfigTypeException;
use Sichev\IrRndLib\TrackConfig;
use PHPUnit\Framework\TestCase;

class TrackConfigTest extends TestCase
{
    public function testTrackManyConfigs()
    {
        $config1 = (object) [
            "name" => "Short",
            "type" => "Slow Road",
            "nascarRoad" => true,
        ];
        $config2 = (object) [
            "name" => "Nationaal",
            "type" => "Fast Road",
            "exceptions" => (object) [
                "cars" => ["Formila"],
                "groups" => ["F11"],
            ],
        ];

        $result = TrackConfig::makeMany([$config2, $config1]);
        $this->assertCount(2, $result);

        foreach ($result as $config)
            if ($config->name === "Short")
                $this->validateShort($config);
            elseif ($config->name === "Nationaal")
                $this->validateNationaal($config);
    }

    public function testNameException()
    {
        $this->expectException(InvalidTrackConfigNameException::class);
        TrackConfig::make((object) [
            "name" => "",
            "type" => "Slow Road",
        ]);
    }

    public function testTypeException()
    {
        $this->expectException(InvalidTrackConfigTypeException::class);
        TrackConfig::make((object) [
            "name" => "Awesome",
            "type" => "Awesome Road",
        ]);
    }

    private function validateShort(TrackConfig $config): void
    {
        $this->assertTrue($config->nascarRoad);
        $this->assertIsArray($config->carsExceptions);
        $this->assertEmpty($config->carsExceptions);
        $this->assertIsArray($config->groupsExceptions);
        $this->assertEmpty($config->groupsExceptions);
    }

    private function validateNationaal(TrackConfig $config): void
    {
        $this->assertFalse($config->nascarRoad);
        $this->assertIsArray($config->carsExceptions);
        $this->assertNotEmpty($config->carsExceptions);
        $this->assertContains("Formila", $config->carsExceptions);
        $this->assertIsArray($config->groupsExceptions);
        $this->assertNotEmpty($config->groupsExceptions);
        $this->assertContains("F11", $config->groupsExceptions);
    }
}
