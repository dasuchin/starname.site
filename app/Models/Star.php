<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    /**
     * @param $ra
     * @return string
     */
    public static function convert_ra($ra) {
        if ($ra < 0)
            $ra = abs($ra);

        $hours = (int)($ra / 15);
        $minutes = (int)((($ra / 15) - $hours) * 60);
        $seconds = number_format((((($ra / 15) - $hours) * 60) - $minutes) * 60, 3);

        return str_pad($hours, 2, "0", STR_PAD_LEFT) . "h " . str_pad($minutes, 2, "0", STR_PAD_LEFT) . "m " . $seconds . "s";
    }

    /**
     * @param $dec
     * @return string
     */
    public static function convert_dec($dec) {
        if($dec < 0)
            $dec = abs($dec);

        $deg = (int)$dec;
        $minutes = abs((int)(($dec - $deg) * 60));
        $seconds = number_format(((abs(($dec - $deg) * 60)) - $minutes) * 60, 2);

        return "+" . str_pad($deg, 2, "0", STR_PAD_LEFT) . json_decode('"' . "\u00B0" . '"') . " " . str_pad($minutes, 2, "0", STR_PAD_LEFT) . "' " . $seconds . '"';
    }
}
