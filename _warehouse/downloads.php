<?php
    include("../data/DBConfig.php");
    include("../MPDF/mpdf.php");
    include_once("../data/sessioncheck.php");
    if(isset($_SESSION['user_id']) ){
     $totalAmount = $_SESSION['product_total_price'];
     $eachAmount   =  $_SESSION['amount'];
     $eachUnitPrice  = $_SESSION['unitPrice'];
    // var_dump($eachAmount);
    // exit;
     }

     $urlPortion = '&array1='.urlencode(serialize($totalAmount)).
                   '&array2='.urlencode(serialize($eachAmount)).
                   '&array3='.urlencode(serialize($eachUnitPrice));
    if($_GET['id'] != ""){
			$vat = 0;
					$id = $database->test_input($_GET['id']);
						if(isset($_GET['vat'])){
							$vat = $database->test_input($_GET['vat']);
						}
						 $grt = $database->getIndGoodsRemoved($id);
						if($grt != null){
                            	$mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0); 
                            	$mpdf->SetDisplayMode('fullpage');
                            	$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
                            	$mpdf->WriteHTML(file_get_contents($host.'document/document.php?id='.$id.$urlPortion));
                            	$mpdf->Output();
						}else{
							echo "<h1 style='color:red'>INVALID TICKET NUMBER</h1>";
						}
		}else{
			echo "<h1 style='color:red'>YOU DID NOT SPECIFY THE TICKET NUMBER</h1>";
		}
?>