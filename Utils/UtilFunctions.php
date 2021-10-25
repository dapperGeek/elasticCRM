<?php
/**
 * Created by PhpStorm.
 * User: Bakar U.A.
 * Date: 9/20/2019
 * Time: 12:09 PM
 */

class UtilFunctions
{
    public static $newSchedule = 'newSchedule';
    public static $oldSchedule = 'oldSchedule';

    public static function textSummary($string){
        $string = strip_tags($string);
        $length = 150;

        if (strlen($string) > $length) {

            // truncate string
            $stringCut = substr($string, 0, $length);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint
                ? substr($stringCut, 0, $endPoint)
                : substr($stringCut, 0);
            $string .= ' ... ';
        }
        return $string;
    }

    public static function makeDate($date){
        return date('jS F Y', strtotime($date));
    }

    public static function getPercentage($arg1, $arg2){
        return $arg2 != 0 ? (($arg1 / $arg2) * 100) . '%' : $arg1;
    }

    public static function getDelayedCalls($serviceCalls){
        $delayed = array();
        $n = 1;
        foreach ($serviceCalls as $serviceCall){
            if ((time() - $serviceCall['openedTimeStamp']) > (24 * 60 * 60 * 3) AND $serviceCall['closedBy'] == 0){
                $delayed[] = $serviceCall;
            }
            else{
                continue;
            }
//            $delayed[] = (time() - $serviceCall['openedTimeStamp']) . ':' . (24 * 60 * 60 * 3);
            $n++;
        }
        return $delayed;
    }

    public static function removeComma($value){
        return str_replace(',', '', $value);
    }

    public static function appURLs($key)
    {
        $urls = [
            'view-calls' => 'view-service-call',
            'make-call' => 'service-call',
            'edit-call' => 'service-call/'
        ];
        return $urls[$key];
    }

    public static function prettyDate($dateString){

    }
}