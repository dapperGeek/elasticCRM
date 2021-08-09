<?php
    include 'includes/header.php';
    $Department = $myData['Department'];
        echo '<center><h1>WELCOME TO '. $_SESSION['department'] .' Department  </h1></center>';
        echo $_SESSION['department'] . ',' . $_SESSION['access'] . ',' . $_SESSION['dptID'];
        ViewLoader::loadView($_SESSION['department']);
?>

    <br><br> <br><br>
<?php
    if (strtolower($_SESSION['department']) == 'customer support')
    {
        $loadFooterJS = 2 ;
    }
    include 'includes/footer.php';