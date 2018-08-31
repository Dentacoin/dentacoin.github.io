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

            <!--Your Wallet Address-->
            <div class="row text-center mt-4">
                <div class="col-lg-12 col-md-12 col-sm-12 item text-center">
                    <span class="text-center text-white " > <strong >Your Dentacoin wallet:</strong></span>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 item text-center">
                    <span  class="text-center text-white"> <a class="" href="#"> <img class="img-fluid" src="./img/copy.svg" width="40px" > </a> <strong class="my-wallet-address" >7182730uasdnmasndasu902183901jksdjkls</strong></span>
                </div>
                <hr>
        </div> <!--End Your Wallet Address-->
       <!--My AMOUNT-->
       <div class="row mt-3 mt-lg-5" style="display:flex!important;">
            <div class="col"></div>
            <table>
                <tbody>
                   <tr>
                      <td class="">
                      </td>
                      <td class="align-middle ">
                            <ul class="col align-middle" style=" list-style-type: none;">
                                <li class="hide-on-desktop hidden-lg hidden-md"> <h1 >
                                    <ul class="col " style=" list-style-type: none; padding-left:0px;">
                                         <li><img src="exchange2.png" width="30px" ></li>
                                         <li class="mt-1" style="font-size:18px; height:auto;"><span> DCN</span></li>
                                         <li><span> 200000</span></li>
                                     </ul>  
                                </li>
                                <li class="show-on-desktop hidden-sm hidden-xs"> <h1 style="font-size:4em;"> <a class="" href="#"> <img src="exchange2.png" width="30px" > </a> 20000 DCN</h1> </li>
                                <li> 
                                    <p class="float-left amount-in-fiat">= 50 USD  
                                        <div class="dropdown ">
                                        <button style="border:none!important;" class="btn btn-outline-secondary dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu">
                                          <a class="dropdown-item" href="#">Euro</a>
                                          <a class="dropdown-item" href="#">Bitcoin</a>
                                        </div>
                                        </button>
                                        <div class="dropdown-menu">
                                          <a class="dropdown-item" href="#">USD</a>
                                          <a class="dropdown-item" href="#">EURO</a>
                                          <a class="dropdown-item" href="#">USDT</a>
                                        </div>
                                      </div>
                                     </p>
                                </li>
                            </ul>
                        </td>
                        <td class="align-middle ">
                            <a class=" col align-middle" href="#">
                               <img class="qr-code img-fluid" src="./img/qr-border.jpg" style="position:relative;" width="205px;" >
                               <img class="qr-code-border img-fluid " src="./img/qrcode.png"  width="195px;" style="position:absolute;  top:-84px; left:18px;" > 
                             </a>
                         </td>
                      </tr>
                    </tbody>
                  </table>

            <div class="col"></div>
        </div>


       <!-- COOLER without table 
            <div class="row text-center mt-4">
                <div class="col"></div>
                <div class="col col-lg-4 col-md-7 col-sm-6 col-xs-6 text-left d-inline-block" >
                        <ul class="" style=" list-style-type: none; ">
                                <li class="hide-on-desktop hidden-lg hidden-md"> <h1 >
                                  <ul class="" style=" list-style-type: none; padding-left:0px;">
                                    <li><img src="exchange2.png" width="30px" ></li>
                                    <li class="mt-1" style="font-size:18px; height:auto;"><span> DCN</span></li>
                                    <li><span> 200000</span></li>
                                  </ul>  
                                </li>
                                <li class="show-on-desktop hidden-sm hidden-xs"> 
                                    <h1 style="font-size:4em;"><a class="" href="#"> <img src="exchange2.png" width="30px" > </a> 20000 DCN</h1> 
                                </li>
                                <li> 
                                    <p class="amount-in-fiat">= 50 USD  
                                        <div class="dropdown ">
                                            <button style="border:none!important;" class="btn btn-outline-secondary dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu">
                                          <a class="dropdown-item" href="#">Euro</a>
                                          <a class="dropdown-item" href="#">Bitcoin</a>
                                        </div>
                                        </button>
                                        <div class="dropdown-menu">
                                          <a class="dropdown-item" href="#">USD</a>
                                          <a class="dropdown-item" href="#">EURO</a>
                                          <a class="dropdown-item" href="#">USDT</a>
                                        </div>
                                      </div>
                                     </p>
                                </li>
                            </ul>
                </div>
                <div class="col col-sm-3 col-lg-5 col-md-5 d-inline "> 
                    <a class="align-middle" href="#">
                        <img class="qr-code-border d-none d-md-inline-block img-fluid align-baseline" src="qr-border.jpg" style="position:relative;" width="205px;" >
                        <img class="qr-code img-fluid d-inline-block" src="qrcode.png"  width="195px;" style="position:absolute;  top:-180px; left:20px;" > 
                    </a>                    
                </div>
                <div class="col"></div>
        </div> --> <!--- THIS IS a cooler version withoout table, but it is still buggy on mobile-->
        
        <!--End My AMOUNT-->

          <?php include("includes/transaction-history.php");?>
          <?php include("includes/footer.php");?>
    </div>
</body>
</html>