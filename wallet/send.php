<?php ?>
<!DOCTYPE html>
<html>
<head>
    <?php include("includes/head-tag-contents.php");?>
</head>
<body class="body" >
<div class="container-fluid">
    <?php include("includes/header.php");?>
    <?php include("includes/navigation.php");?>

        <!--Input wallet address field-->
        <div class="row text-center mt-4">
           <input class="col-lg-6 col-md-10 col-8 form-control input-lg d-inline" id="inputlg" type="text" placeholder="Input wallet address or Clinic's name">
           <a href="send-input.php"> <img class="col-lg-1 col-md-1 col-sm-1 d-inline" src="./img/copy.svg"  style="max-width:100px"> </a>
        </div> <!--End Input wallet address field-->
        <!--Input Inforamtion Text-->
        <div class="row text-center mt-4 pl-4 pr-4">
            <div class="text-center">
                    <img class="hide-on-mobile img-responsive " src="./img/Line.png" width="2px" style="margin:0 auto:">
                     <p class="text-center"> Fill the address or the name of the clinic that you want to Send DCN, in the field above.
                     </p>
            </div>
        </div> <!--End Input Inforamtion Text-->

          <?php include("includes/transaction-history.php");?>
          <?php include("includes/footer.php");?>
    </div>
</body>
</html>