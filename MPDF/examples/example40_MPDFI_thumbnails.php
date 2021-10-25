<<<<<<< HEAD
<?php

include("../mpdf.php");

$mpdf=new mPDF(); 
$mpdf->SetImportUse();	

$mpdf->Thumbnail('sample_orientation2.pdf', 4, 5);	// number per row	// spacing in mm

$mpdf->WriteHTML('<pagebreak /><div>Now with rotated pages</div>');

$mpdf->Thumbnail('sample_orientation3.pdf', 4);	// number per row	// spacing in mm


$mpdf->Output();

exit;


=======
<?php

include("../mpdf.php");

$mpdf=new mPDF(); 
$mpdf->SetImportUse();	

$mpdf->Thumbnail('sample_orientation2.pdf', 4, 5);	// number per row	// spacing in mm

$mpdf->WriteHTML('<pagebreak /><div>Now with rotated pages</div>');

$mpdf->Thumbnail('sample_orientation3.pdf', 4);	// number per row	// spacing in mm


$mpdf->Output();

exit;


>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
?>