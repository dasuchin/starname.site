<?php

namespace App\Traits;

trait ResolvesOrderProperties
{
    protected static $prefixes = [
        1 => "In Honor Of ",
        2 => "In Memory Of ",
        3 => "With Love To "
    ];

    protected static $packages = [
        'digital'               => 'Digital Star Package',
        'premium'               => 'Premium Star Package',
        'ultimate'              => 'Ultimate Star Package',
        'digital_membership'    => 'Digital Membership',
        'premium_membership'    => 'Premium Membership',
        'ultimate_membership'   => 'Ultimate Membership'
    ];

    protected static $zmap = [
        "aries"         => null,
        "taurus"        => [9],
        "gemini"        => [3],
        "cancer"        => [10],
        "leo"           => [10],
        "virgo"         => [11, 12],
        "libra"         => null,
        "scorpio"       => [19],
        "sagittarius"   => [6, 19],
        "capricorn"     => null,
        "aquarius"      => [13, 14],
        "pisces"        => [20]
    ];
    
    protected function resolvePrefixFromIndex($index)
    {
        return array_get(static::$prefixes, $index, '');
    }

    protected function resolvePackageDescriptionFromCode($code)
    {
        return array_get(static::$packages, $code, '');
    }

    protected function resolveMapChoicesFromZodiac($zodiac)
    {
        return array_get(static::$zmap, $zodiac, '');
    }
}
