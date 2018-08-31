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
        <!--Iput Field desktop-->
        <div class="row d-sm-none d-xs-none d-lg-block d-md-block text-center mt-4 ">
            <strong class="d-none d-lg-inline-block d-md-inline-block col-lg-4 col-md-5 col-sm-5 col-xs-4 " style="font-size: 14px; color:white; text-align:left;">Pay with</strong>  
            <strong class="d-none d-lg-inline-block d-md-inline-block col-lg-4 col-md-5 col-sm-5 col-xs-4 " style="font-size: 14px; color:white; text-align:right;">You get</strong>  
       </div> 
       <div class="row buy-field-desktop text-center   ">
         <div class=" col-lg-4 col-md-5 col-sm-12 col-xs-12 d-inline-block" style="">
                <strong class="d-lg-none d-md-none d-sm-inline-block d-xs-inline-block col-sm-4" style="font-size: 14px; color:white; text-align:left;">Pay with</strong>  
                   <div class="col-lg-6 col-md-10 col-sm-4 d-inline form-input-group">
                       <input class="form-input-control " type="text" class="" aria-label="Text input with dropdown button" >
                           <div class="form-input-append">
                               <button class="btn btn-light dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">USD</button>
                               <div class="dropdown-menu">
                                   <a class="dropdown-item" href="buy-credit-card2.html">DCN</a>
                                   <a class="dropdown-item" href="#">Euro</a>
                                   <a class="dropdown-item" href="#">Bitcoin</a>
                               </div>
                            </div>
                   </div>
            </div> 
            <div class="d-none col-lg-3 col-md-2 d-md-inline-block d-lg-inline-block mr-4 ml-4" style="width:40px;">  
                    <img src="./img/exchange.png" width="40px" >
            </div>
            <div class="send-input-mobile col-lg-4 col-md-5 col-sm-12 col-xs-12 d-inline-block mr-4" style="">
                    <strong class="d-lg-none d-md-none d-sm-inline-block d-xs-inline-block" style="font-size: 14px; color:white; text-align:right;">You get</strong>  
                    <div class="col-lg-6 col-md-10 col-sm-2 col-4 d-inline form-input-group">
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
       <!--Iput Field Mobile-->
        <div class="row d-lg-none d-md-none  text-center mt-4">
            <ul class="list-unstyled pl-4 pr-4">
                <li class="pb-2"> 
                    <div class="input-group ">
                            <strong class=" text-white mr-3 pt-2">Pay with</strong>
                        <input type="text" class="form-control" aria-label="Text input with dropdown button">
                        <div class="input-group-append">
                          <button class="btn btn-outline dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">BTC</button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="buy-credit-card.php">USD</a>
                            <a class="dropdown-item" href="#">Euro</a>
                            <a class="dropdown-item" href="#">BTC</a>
                           <!-- <div role="separator" class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Separated link</a> 
                          </div>-->
                        </div>
                        </div>
                    </div>
                </li>
                <li> 
                    <div class="input-group ">
                                    <strong class=" text-white mr-3 pt-2">You get</strong>
                                <input type="text" class="form-control" aria-label="Text input with dropdown button">
                                <div class="input-group-append">
                                  <button class="btn btn-outline dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">DCN</button>
                                  <div class="dropdown-menu">
                                    <a class="dropdown-item" href="buy-credit-card2.html">USD</a>
                                    <a class="dropdown-item" href="#">Euro</a>
                                    <a class="dropdown-item" href="#">BTC</a>
                                   <!-- <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a> 
                                  </div>-->
                                </div>
                                </div>
                    </div>
                 </li>
            </ul> 
        </div> <!--End Iput Field Mobile-->
        <!--Input wallet address field-->
        <div class="row text-center mt-4 pl-4 pr-4">
            <div class="text-center">
                    <img class="hide-on-mobile img-responsive d-sm-none d-xs-none" src="./img/Line.png" width="2px" style="margin:0 auto:">
                     <p class="text-center">  Choose the currency that you want to pay with and receive, from the drop-down menu.
                            <br> Than input the amount that you want to be exchanged.
                     </p>
            </div>
        </div> <!--End Input wallet address field-->

          <?php include("includes/transaction-history.php");?>
          <?php include("includes/footer.php");?>
    </div>
</body>
</html>