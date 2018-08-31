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
           <img class="col-lg-1 col-md-1 col-sm-1 d-inline" src="copy.svg"  style="max-width:100px">
        </div> <!--End Input wallet address field-->
        <!--Iput Field desktop-->
        <div class="row text-center mt-4">
             <strong class="" style="font-size: 14px; color:black; text-align:center;">Input the amount that you want to send in DCN ot USD</strong>
        </div>
        <div class="row text-center mt-4">
          <div class="send-input-mobile col-lg-4 col-md-5 col-sm-12 col-xs-12 d-inline-block" style="width:calc(45%-20px)">
                    <div class="col-lg-6 col-md-10 col-4 d-inline form-input-group">
                        <input class="form-input-control" type="text" class="" aria-label="Text input with dropdown button" >
                            <div class="form-input-append">
                                <button class="btn btn-light dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">USD</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="buy-credit-card.php">DCN</a>
                                    <a class="dropdown-item" href="#">Euro</a>
                                    <a class="dropdown-item" href="#">Bitcoin</a>
                                </div>
                             </div>
                    </div>
             </div> 
             <h1 class="d-none d-md-inline-block pl-5 col-lg-1 ">=</h1>
             <div class="d-none d-md-inline-block col-lg-4 col-md-5" style="width:calc(45%-20px)">
                     <div class="col-lg-6 col-md-10 col-4 d-inline form-input-group">
                             <div class="form-input-append">
                                    <button class="btn btn-light dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">DCN</button>
                                 <div class="dropdown-menu">
                                     <a class="dropdown-item" href="buy-credit-card.php">DCN</a>
                                     <a class="dropdown-item" href="#">Euro</a>
                                     <a class="dropdown-item" href="#">Bitcoin</a>
                                 </div>
                              </div>
                              <input class="form-input-control" type="text" class="" aria-label="Text input with dropdown button" >
                     </div>
              </div>   
        </div> <!--End Iput Field desktop-->   

          <?php include("includes/transaction-history.php");?>
          <?php include("includes/footer.php");?>
    </div>
</body>
</html>