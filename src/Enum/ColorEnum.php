<?php

namespace App\Enum;

abstract class ColorEnum {

    const YELLOW    = 0;
    const RED       = 1;
    const GREEN     = 2;
    const COLORLESS = 3;

    protected static $colorName = [
        self::YELLOW        => 'Jaune',
        self::RED           => 'Route',
        self::GREEN         => 'Vert',
        self::COLORLESS     => 'Sans-Couleur'
    ];

    public static function getChoices() {
        return static::$colorName;
    }

    public static function getColorName($choice){
        if (!isset(static::$colorName[$choice]))
        {
            return "sans couleur";
        }
        return static::$colorName[$choice];
    }



}