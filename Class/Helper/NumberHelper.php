<?php
namespace app\Helper;

class NumberHelper {

    public static function format(float $number, string $sigle="$"): string {
        return number_format($number, 0, '', ' ') . ' ' . $sigle ;
    }


}


?>