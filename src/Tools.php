<?php

namespace Sichev\IrRndLib;

readonly class Tools
{
    public static function rearrangeArray(array &$array): void
    {
        $array = [...$array];
    }

    public static function getRandomElement(array $array): mixed
    {
        self::rearrangeArray($array);
        return $array[mt_rand(0, count($array) - 1)];
    }

}