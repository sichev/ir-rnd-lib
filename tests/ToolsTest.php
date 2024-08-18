<?php

namespace Sichev\IrRndLib\Tests;

use Sichev\IrRndLib\Tools;
use PHPUnit\Framework\TestCase;

class ToolsTest extends TestCase
{
    public function testRearrangeArray()
    {
        $testArray = [1 => "zazaza", 8 => "ABC", 10 => "5"];
        Tools::rearrangeArray($testArray);
        $this->assertEquals([0 => "zazaza", 1 => "ABC", 2 => "5"], $testArray);
    }

    public function testRandomElement()
    {
        $testArray = [1 => "zazaza", 8 => "ABC", 10 => "5"];
        $randomElement = Tools::getRandomElement($testArray);
        $this->assertTrue(
            $randomElement === "zazaza" or
            $randomElement === "ABC" or
            $randomElement === "5"
        );
    }
}
