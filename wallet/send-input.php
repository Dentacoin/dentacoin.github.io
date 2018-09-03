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
           <span class="col-lg-6 col-md-10 col-8 d-inline text-white">Sent to:<span id="send-wallet">0x13D0c7ADA3F98EEc232ed7E57FeFc4c300f25095</span></span>
           <a href="send.php"><img class="edit-icon col-lg-1 col-md-1 col-sm-1 d-inline" src="./img/edit.png"  style="max-width:100px"></a>
        </div> <!--End Input wallet address field-->
        <!--Iput Field desktop--> 
       <div class="row buy-field-desktop text-center mt-4">
         <div class=" col-lg-4 col-md-5 col-sm-12 col-xs-12 d-inline-block" style="">
                   <div class="col-lg-6 col-md-10 col-sm-4 d-inline form-input-group">
                       <input class="form-input-control " type="text" class="" aria-label="Text input with dropdown button" >
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
            <div class="d-none col-lg-3 col-md-2 d-md-inline-block d-lg-inline-block mr-4 ml-4" style="width:40px;">  
                    <img src="./img/equal.png" width="40px" style="margin-left:-8px;">
            </div>
            <div class="send-input-mobile col-lg-4 col-md-5 col-sm-12 col-xs-12 d-inline-block mr-4" style="">
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
        <div class="row d-lg-none d-md-none d-sm-block d-xs-block text-center mt-4">
            <ul class="list-unstyled pl-4 pr-4">
                <li class="pb-2"> 
                    <div class="input-group ">
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
        <div class="row text-center mt-2 pl-4 pr-4">
            <div class="text-center">
                     <p class="text-center">  Input the amount that you want to send to the wallet address above.</p>
            </div>
        </div> <!--End Input wallet address field-->
        <div class="row text-center mt-4 ">
             <button type="button" class="btn btn-info mt-2" data-toggle="modal" data-target="#exampleModalCenter" style="padding:10px 120px; "> Send </button>
        </div>
          <?php include("includes/transaction-history.php");?>
          <?php include("includes/footer.php");?>
    </div>
</body>
</html>