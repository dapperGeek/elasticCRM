<?php
/**
 * Created by PhpStorm.
 * User: OLUYEMI
 * Date: 9/20/2019
 * Time: 12:09 PM
 */

class UtilFunctions
{
    public static function textSummary($string){
        $string = strip_tags($string);
        $length = 150;

        if (strlen($string) > $length) {

            // truncate string
            $stringCut = substr($string, 0, $length);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= ' ... ';
        }
        return $string;
    }
}