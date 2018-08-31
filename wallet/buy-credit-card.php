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
                                   <a class="dropdown-item" href="../buy/buy-credit-card.html">DCN</a>
                                   <a class="dropdown-item" href="#">Euro</a>
                                   <a class="dropdown-item" href="#">Bitcoin</a>
                               </div>
                            </div>
                   </div>
            </div> 
            <div class="d-none col-lg-3 col-md-2 d-md-inline-block d-lg-inline-block mr-4 ml-4" style="width:40px;">  
                    <img src="../img/exchange.png" width="40px" >
            </div>
            <div class="send-input-mobile col-lg-4 col-md-5 col-sm-12 col-xs-12 d-inline-block mr-4" style="">
                    <strong class="d-lg-none d-md-none d-sm-inline-block d-xs-inline-block" style="font-size: 14px; color:white; text-align:right;">You get</strong>  
                    <div class="col-lg-6 col-md-10 col-sm-2 col-4 d-inline form-input-group">
                            <div class="form-input-append">
                                   <button class="btn btn-light dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">DCN</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="../buy/buy-credit-card.html">DCN</a>
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
                <li> 
                    <div class="input-group ">
                                    <strong class=" text-white mr-3 pt-2">You get</strong>
                                <input type="text" class="form-control" aria-label="Text input with dropdown button">
                                <div class="input-group-append">
                                  <button class="btn btn-outline dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">DCN</button>
                                  <div class="dropdown-menu">
                                    <a class="dropdown-item" href="../buy/buy-credit-card.html">USD</a>
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
        <!--Credit Card Details Input-->
        <div class="row text-center mt-4  credit-card-card">
                <div class="col"></div>
                   <div class="demo-container ">
                           <a href="../buy/buy-credit-card.html#number" ><div class="card-wrapper mb-3"></div></a>
                           <div class="form-container active">
                               <form class="card-form credit-card-input" action="">
                                   <input id="number" class="card-input" placeholder="Card number" type="tel" name="number">
                                   <input class="card-input" placeholder="Full name" type="text" name="name">
                                   <input class="card-input" placeholder="MM/YY" type="tel" name="expiry">
                                   <input class="card-input" placeholder="CVC &#128274; " type="number" name="cvc" >
                                   <!-- Button trigger modal -->
                                   <button type="button" class="btn btn-info mt-2" data-toggle="modal" data-target="#exampleModalCenter" style="padding:10px 120px; "> Next </button>
                                        <!-- Modal Pop-UP 1 Input Pin Code -->
                                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Input Your Pin Code</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="formType" value="confirmPassword">
                                                            <div class="form-group">
                                                            <div class="col-sm-12 col-sm-5 text-center">
                                                                 <input name="firstdigit" class="digit text-center" type="password" required id="firstdigit" size="1" maxlength="1" tabindex="0">
                                                                 <input name="secondtdigit" class="digit text-center" type="password" required id="firstdigit" size="1" maxlength="1" tabindex="1">
                                                                 <input name="thirddigit" class="digit text-center" type="password" required id="thirddigit" size="1" maxlength="1"  tabindex="2" >
                                                                 <input name="fourthdigit" class="digit text-center" type="password" required id="fourthdigit" size="1" maxlength="1" tabindex="3">
                                                            </div>
                                                            <script> 
                                                                $( document ).ready(function() {
                                                                 $('#digitPasswordbtn').click(function() {
                                                                   $('#digitPassword').modal('show');
                                                                 });
                                                                 $(":input[type='password']").keyup(function(event){
                                                                   if ($(this).next('[type="password"]').length > 0){
                                                                       $(this).next('[type="password"]')[0].focus();
                                                                   }else{
                                                                       if ($(this).parent().next().find('[type="password"]').length > 0){
                                                                           $(this).parent().next().find('[type="password"]')[0].focus();
                                                                       }
                                                                   }
                                                                });
                                                                $('#digitPassword').on('shown.bs.modal', function (e) {
                                                                   $("#firstdigit").focus();
                                                                 });
                                                                });
                                                            </script>
                                                        </div>
                                                    <div class="modal-footer" style="display:block!important;">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width:40%;" >Back</button>
                                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter2" style="width:40%;" >Next</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!--End Modal Pop-UP 1 Input Pin Code -->
                                        <!-- Modal Pop-UP 2 Transaction Details -->
                                        <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Transaction details</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <h2 class="mb-4"> Are you sure you want to buy:</h2>
                                                            <ul class="text-center" style="list-style:none; text-align:center; padding-left:0px!important;">
                                                                <li><strong>2 000 000 DCN</strong></li>
                                                                <li>(2 000 000 USD)</li>
                                                                <li>from</li>
                                                                <li>Your credit card details</li>
                                                                <li><hr></li>
                                                                <li>Transaction fee: <p>0,009 USD</p></li>
                                                                <li><hr></li>
                                                                <li><h3>TOTAL: 2 000 009 USD</h3></li>
                                                            </ul>
                                                        </div>
                                                    <div class="modal-footer" style="display:block!important;">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width:40%;">Back</button>
                                                        <button type="button" class="btn btn-info"data-toggle="modal" data-target="#exampleModalCenter3" style="width:40%;">BUY</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- End Modal Pop-Up 2 Transaction Details -->
                                        <!-- Modal Pop-UP 3 Successful Transaction -->
                                        <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Transaction details</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <h2 class="mb-4" style="margin-top:20px; ">Successful Transaction</h2>
                                                            <img src="./img/success.png" width="200px;" style="margin-top:20px; margin-bottom:20px;">
                                                        </div>
                                                    <div class="modal-footer" style="display:block!important;">
                                                        <button type="button" data-dismiss="modal" class="btn btn-secondary" style="width:40%;">Close</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- End Modal Pop-Up 3 Successful Transaction -->
                               </form>
                           </div>
                    </div>
            <div class="col"></div>
        </div> <!--End Credit Card Details Input-->

          <?php include("includes/transaction-history.php");?>
          <?php include("includes/footer.php");?>
    </div>
<script src="../js/card.js"></script> 
<script>
        new Card({
            form: document.querySelector('form'),
            container: '.card-wrapper'
        });
</script>    
</body>
</html>