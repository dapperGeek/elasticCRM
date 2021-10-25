<?php
/**
 * Created by PhpStorm.
 * User: BAKAR U.A.
 * Date: 25-Oct-19
 * Time: 3:33 PM
 */

class PageHeaders
{
    private static function myHeaders($index) : string
    {
        $pageHeader = [
           0 => 'createServiceCall',
           1 => 'editServiceCall',
           2 => 'viewServiceCall',
           3 => 'viewSoldTickets',
           4 => 'viewStock',
           5 => 'allContracts',
           6 => 'viewPmAccounts',
           7 => 'followUpCall',
           8 => 'addShowroomMachine',
           9 => 'viewShowroomMachine',
           10 => 'viewStockAnalysis',
           11 => 'addMachine',
           12 => 'stockToOrder',
           13 => 'viewWorkshop',
           14 => 'engineerViewServiceCall'
        ];
        return $pageHeader[$index];
    }

    static function common() : string
    {
        return "<ol class=\"breadcrumb\">
                        <li> <a href=\"index.php\">Home</a> </li>";
    }

    public static function getTitle($page) : string
    {
        $pageTitle = '';
        switch ($page)
        {
            case self::myHeaders(0):
                $pageTitle = 'Create Service Call';
                break;
            case self::myHeaders(1):
                $pageTitle = 'Update Service Call';
                break;
            case self::myHeaders(2):
                $pageTitle = 'View All Service Calls';
                break;
            case self::myHeaders(3):
                $pageTitle = 'All Sold Tickets';
                break;
            case self::myHeaders(4):
                $pageTitle = 'View Stock';
                break;
            case self::myHeaders(5):
                $pageTitle = 'All Contracts';
                break;
            case self::myHeaders(6):
                $pageTitle = 'All PM Accounts';
                break;
            case self::myHeaders(7):
                $pageTitle = 'Follow-up Service Call';
                break;
            case self::myHeaders(8):
                $pageTitle = 'Add Showroom Machine';
                break;
            case self::myHeaders(9):
                $pageTitle = 'View Showroom Machine';
                break;
            case self::myHeaders(10):
                $pageTitle = 'Stock Analysis';
                break;
            case self::myHeaders(11):
                $pageTitle = 'Add Machine';
                break;
            case self::myHeaders(12):
                $pageTitle = 'Stock To Order';
                break;
            case self::myHeaders(13):
                $pageTitle = 'View Workshop Machine';
                break;
            default:
                $pageTitle = 'Elastic-25+';
                break;
        }
        return 'Elastic-25+|| ' . $pageTitle;
    }

    public static function getHeading($page) : string
    {
        $heading = '';
        switch ($page)
        {
            case self::myHeaders(0):
                $heading = self::common() . "
                        <li> <a>Account</a> </li>
                    <li class=\"active\"> <strong>Service Call </strong> </li>
                </ol>" ;
                 break;
             case self::myHeaders(1):
                 $heading = self::common() . "
                        <li> <a>Account</a> </li>
                    <li class=\"active\"> <strong>Update Service Call</strong> </li>
                </ol>" ;
                 break;
             case self::myHeaders(2):
                 $heading = self::common() . "
                        <li> <a>Service App</a> </li>
                        <li> <a>Service Calls</a> </li>
                        <li class=\"active\"> <strong>View All Service Calls</strong> </li>
                    </ol>" ;
                 break;
             case self::myHeaders(3):
                 $heading = self::common() . "
                        <li> <a>Goods Sold Tickets</a> </li>
                        <li class=\"active\"> <strong>All Goods Left</strong> </li>
                        </ol>
                        ";
                 break;
             case self::myHeaders(4):
                 $heading = self::common() . "
                        <li> <a>Settings</a> </li>
                        <li> <a>Products</a> </li>
                        <li class=\"active\"> <strong>View All Products</strong> </li>
                        </o>
                        ";
                 break;
             case self::myHeaders(5):
                $type = strtoupper($_GET['type']);

                $heading = self::common() . "
                        <li> <a>Contracts</a> </li>
                        <li class=\"active\"> <strong>$type Accounts</strong> </li>
                        </ol>
                        ";
                 break;
             case self::myHeaders(6):
                $heading = '<h2>View All Customer Accounts for Preventive Maintenance</h2>'
                    . self::common() . "
                    <li> <a>Preventive Maintenance</a> </li>
                    <li> <a>Accounts</a> </li>
                    <li class=\"active\"> <strong>View Accounts</strong> </li>
                    </ol>";
                 break;
             case self::myHeaders(7):
                $heading = '<h2>Follow Up Call</h2>'
                    . self::common() . "
                    <li> <a>Service Calls</a> </li>
                    <li> <a>Accounts</a> </li>
                    <li class=\"active\"> <strong>Follow Up Call</strong> </li>
                    </ol>";
                 break;
             case self::myHeaders(8):
                $heading = '<h2>Showroom Inventory</h2>'
                    . self::common() . "
                    <li> <a>Showroom</a> </li>
                    <li class=\"active\"> <strong>Add Machine To Showroom</strong> </li>
                    </ol>";
                 break;
             case self::myHeaders(9):
                $heading = '<h2>Showroom Inventory</h2>'
                    . self::common() . "
                    <li> <a>Showroom</a> </li>
                    <li class=\"active\"> <strong>View Showroom Machines</strong> </li>
                    </ol>";
                 break;
             case self::myHeaders(10):
                $heading = '<h2>View Stock Analysis</h2>'
                    . self::common() . "
                    <li> <a>Settings</a> </li>
                    <li> <a>Products</a> </li>
                    <li class=\"active\"><strong>Stock Analysis</strong></li>
                    </ol>";
                 break;
             case self::myHeaders(11):
                $heading = '<h2>Add Machine Information</h2>'
                    . self::common() . "
                   <li> <a>Account</a> </li>
                    <li class=\"active\"> <strong>Add Machine </strong> </li>
                    </ol>";
                 break;
             case self::myHeaders(12):
                $heading = '<h2>View Stock To Order</h2>'
                    . self::common() . "
                   <li> <a>Settings</a> </li>
            <li> <a>Products</a> </li>
            <li class=\"active\"> <strong>Stock To Order</strong> </li>
          </ol>";
                 break;
             case self::myHeaders(13):
                $heading = '<h2>View All Machines In Workshop</h2>'
                    . self::common() . "
                   <li> <a>Administrative</a> </li>
            <li> <a>Shop</a> </li>
            <li class=\"active\"> <strong>View Workshop</strong> </li>
          </ol>";
                 break;
            case self::myHeaders(14):
                $heading = self::common() . "
                        <li> <a>Service App</a> </li>
                        <li> <a>Service Calls</a> </li>
                        <li class=\"active\"> <strong>View My Service Calls</strong> </li>
                    </ol>" ;
                break;
         }
         return $heading;
    }
}