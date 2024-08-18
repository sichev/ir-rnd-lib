<?php

namespace Sichev\IrRndLib\Tests;

use ReflectionClass;
use Sichev\IrRndLib\Types;
use PHPUnit\Framework\TestCase;

class TypesTest extends TestCase
{
    public function testKnownTypesConstants()
    {
        $expectedConstants = ['CAR_TYPES', 'URL_CAR_TYPES', 'CONFIGS', 'CAR_GROUPS'];
        $types = new ReflectionClass(Types::class);
        $TypesConstants = $types->getConstants();
        foreach ($expectedConstants as $expectedConstant) {
            $this->assertArrayHasKey($expectedConstant, $TypesConstants);
            $this->assertIsArray($TypesConstants[$expectedConstant]);
            $this->assertNotEmpty($TypesConstants[$expectedConstant]);
        }
    }
}
