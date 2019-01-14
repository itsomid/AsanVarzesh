<?php


namespace App\Helpers;


class Helper
{
    public static function homePageURL()
    {
        return url('/');
    }

    public function convert($input)
    {
        $unicode = array('۰', '۱', '۲', '۳', '٤', '٥', '٦', '۷', '۸', '۹');
        $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

        $string = str_replace($unicode, $english , $input);

        return $string;
    }

}