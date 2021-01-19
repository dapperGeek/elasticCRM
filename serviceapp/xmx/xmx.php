<?php
    include("../../data/DBConfig.php");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Chosen: A jQuery Plugin by Harvest to Tame Unwieldy Select Boxes</title>

  <link rel="stylesheet" href="chosen.css">
  <style type="text/css" media="all">
    /* fix rtl for demo */
    .chosen-rtl .chosen-drop { left: -9000px; }
  </style>
  
</head>
<body>

          <select data-placeholder="Choose an Item..." class="chosen-select form-control" style="width:350px;" tabindex="2">
            <option value=""></option>
            <?php
    $dpts = (array)$database->getAllProducts();
    foreach ($dpts as $dpt) {
         if($dpt['Code'] == ""){continue;}
?>
    <option value="<?php echo $dpt['productName'];?>"><?php echo $dpt['productName'];?>          <?php echo $dpt['Code'];?> </option>  </div>
<?php }?>
          </select>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
  <script src="chosen.jquery.js" type="text/javascript"></script>
  <script src="docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
  </form>
