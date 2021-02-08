<?php
/**
 * Created by PhpStorm.
 * User: Bakar U.A.
 * Date: 13-Nov-19
 * Time: 8:52 AM
 */

class ViewLoader{

    public static function loadView($department)
    {
        $dept = strtolower(str_replace(' ', '_', $department));
        if (file_exists("views/$dept.php"))
        {
            $view = "views/$dept.php" ;
        }
        else
        {
            $view = file_exists('../font.php') ? '../font.php' : 'font.php';
        }
        return include("$view");
    }
}