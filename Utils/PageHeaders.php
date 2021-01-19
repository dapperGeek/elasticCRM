<?php
/**
 * Created by PhpStorm.
 * User: BAKAR U.A.
 * Date: 25-Oct-19
 * Time: 3:33 PM
 */

class PageHeaders
{
    function common(){
        return "<ol class=\"breadcrumb\">
                        <li> <a href=\"index.php\">Home</a> </li>";
    }

    public static function getHeading($page)
    {
        $heading = '';
         switch ($page)
         {
             case 'createServiceCall':
                 $heading = self::common() . "
                        <li> <a>Account</a> </li>
                    <li class=\"active\"> <strong>Service Call </strong> </li>
                </ol>" ;
                 break;
             case 'viewServiceCall':
                 $heading = self::common() . "
                        <li> <a>Administrative</a> </li>
                        <li> <a>Tickets</a> </li>
                        <li class=\"active\"> <strong>View All Tickets</strong> </li>
                    </ol>" ;
                 break;
             case 'viewSoldTickets':
                 $heading = self::common() . "
                        <li> <a>Goods Sold Tickets</a> </li>
                        <li class=\"active\"> <strong>All Goods Left</strong> </li>
                        </ol>
                        ";
                 break;
             case 'viewStock':
                 $heading = self::common() . "
                        <li> <a>Settings</a> </li>
                        <li> <a>Products</a> </li>
                        <li class=\"active\"> <strong>View All Products</strong> </li>
                        </o>
                        ";
                 break;
             case 'allContracts';
                $type = strtoupper($_GET['type']);

                $heading = self::common() . "
                        <li> <a>Contracts</a> </li>
                        <li class=\"active\"> <strong>$type Accounts</strong> </li>
                        </ol>
                        ";
                 break;
             case 'viewPmAccounts';
                $heading = '<h2>View All Customer Accounts for Preventive Maintenance</h2>'
                    . self::common() . "
                    <li> <a>Preventive Maintenance</a> </li>
                    <li> <a>Accounts</a> </li>
                    <li class=\"active\"> <strong>View Accounts</strong> </li>
                    </ol>";
                 break;
             case 'followUpCall';
                $heading = '<h2>Follow Up Call</h2>'
                    . self::common() . "
                    <li> <a>Service Calls</a> </li>
                    <li> <a>Accounts</a> </li>
                    <li class=\"active\"> <strong>Follow Up Call</strong> </li>
                    </ol>";
                 break;
             case 'addShowroomMachine';
                $heading = '<h2>Showroom Inventory</h2>'
                    . self::common() . "
                    <li> <a>Showroom</a> </li>
                    <li class=\"active\"> <strong>Add Machine To Showroom</strong> </li>
                    </ol>";
                 break;
             case 'viewShowroomMachine';
                $heading = '<h2>Showroom Inventory</h2>'
                    . self::common() . "
                    <li> <a>Showroom</a> </li>
                    <li class=\"active\"> <strong>View Showroom Machines</strong> </li>
                    </ol>";
                 break;
         }

         return $heading;
    }
}