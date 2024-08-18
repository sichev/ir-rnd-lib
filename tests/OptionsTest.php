<?php

namespace Sichev\IrRndLib\Tests;

use PHPUnit\Framework\TestCase;
use Sichev\IrRndLib\Exceptions\InvalidInputCarTypeException;
use Sichev\IrRndLib\Options;

class OptionsTest extends TestCase
{
    public function testOptionsFactoryException()
    {
        $this->assertIsObject(Options::make(car: 'any'));
        $this->expectException(InvalidInputCarTypeException::class);
        Options::make(car: 'test');
    }

    public function testOptionsFactoryException2()
    {
        $this->expectException(InvalidInputCarTypeException::class);
        new Options(car: 'any');
    }
}
