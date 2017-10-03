<!DOCTYPE html>
<html lang="en" class="wide wow-animation">
  <head>
    <title>Wallet</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="../web/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,600,700">
    <link rel="stylesheet" href="../web/css2/min.style.css">
    <!-- mailchimp counter -->
    <?php include '../web/php_functions/mailchimp_functions.php'?>
		<!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="js/html5shiv.min.js"></script>
        <![endif]-->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-97167262-1', 'auto');
        ga('send', 'pageview');
    </script>
    <!-- <script src="../web/js2/jquery-2.2.2.min.js"></script> -->
    <script src="../web/js2/jquery-3.1.1.min.js"></script>
  </head>
  <body>
    <div id="particles-js"></div>
    <div class="page">
      <div class="page-loader page-loader-variant-1">
        <div><a href="index.html" class="brand brand-md brand-inverse"><img src="../dentacoinicon.png" alt="" width="135" height="34"/></a>
          <div class="page-loader-body">
            <div id="spinningSquaresG">
              <div id="spinningSquaresG_1" class="spinningSquaresG"></div>
              <div id="spinningSquaresG_2" class="spinningSquaresG"></div>
              <div id="spinningSquaresG_3" class="spinningSquaresG"></div>
              <div id="spinningSquaresG_4" class="spinningSquaresG"></div>
              <div id="spinningSquaresG_5" class="spinningSquaresG"></div>
              <div id="spinningSquaresG_6" class="spinningSquaresG"></div>
              <div id="spinningSquaresG_7" class="spinningSquaresG"></div>
              <div id="spinningSquaresG_8" class="spinningSquaresG"></div>
            </div>
          </div>
        </div>
      </div>
    <header class="page-head">
        <div class="rd-navbar-wrap">
          <nav data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static" data-stick-up-clone="false" data-md-stick-up-offset="53px" data-lg-stick-up-offset="53px" data-md-stick-up="true" data-lg-stick-up="true" class="rd-navbar rd-navbar-corporate-dark">
            <div class="rd-navbar-inner">
              <div class="rd-navbar-group rd-navbar-search-wrap">
                <div class="rd-navbar-panel">
                  <button data-custom-toggle=".rd-navbar-nav-wrap" data-custom-toggle-disable-on-blur="true" class="rd-navbar-toggle"><span></span></button><a href="https://dentacoin.com" class="rd-navbar-brand brand"><img src="../web/img/logo.png" alt="" width="50" height="50"/></a>
                </div>
                <div class="rd-navbar-nav-wrap">
                  <div class="rd-navbar-nav-inner">
                    <ul class="rd-navbar-nav">
                        <li><a href="https://www.dentacoin.com/">Home</a>
                        </li>
                        <li><a href="..\white-paper\Whitepaper-en.pdf" target="_blank">Whitepaper</a>
                        </li>
                        <li><a href="https://www.dentacoin.com/#who">Team</a>
                        </li>
                        <li><a href="https://dentacoin.com/ico-faq/">FAQ</a>
                        </li>
                        <li><a href="https://www.dentacoin.com/ico/">ICO</a>
                        </li>
                        <li><a href="https://www.dentacoin.com/wallet/">Wallet</a>
                        </li>
                        <li><a href="https://www.dentacoin.com/blog/" target="_blank">Blog</a>
                        </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </nav>
        </div>
        <div class="divider-fullwidth bg-porcelain"></div>
    </header>

    <section id="what" class="text-center section-75">
        <div class="shell">
            <div class="range">
                <div class="cell-xs-12">
                    <div class="countdown-wrap block-centered">
                        <h4 class="">Dentacoin Token Sale starts in:</h4>
                        <div data-type="until" data-date="2017-10-01 14:00:00" data-format="wdhms" data-color="#126585" data-bg="rgba(255,255,255,0.2)" data-width="0.02" class="DateCountdown DateCountdown-1"></div>
                    </div>
                </div>
            </div>
            <div class="range range-sm-center offset-top-120">
                <div class="lead about-text cell-sm-6 cell-md-5 cell-lg-4 offset-top-0 offset-sm-top-0 offset-xl-top-0" id="mc_embed_signup">
                    <p style="font-size: 16px;" class="offset-top-15"><span class="text-blue text-ubold h6"><?php echo get_member_count(); ?></span> subscribers waiting for the start…</p>
                    <form action="//dentacoin.us15.list-manage.com/subscribe/post?u=2db886e44db15e869246f6964&amp;id=871dc3bc90" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate form-modern form-inverse offset-top-10" target="_blank" novalidate>
                      <div class="form-group" id="mc_embed_signup_scroll">
                        <input id="contact-email" type="email" name="b_2db886e44db15e869246f6964_871dc3bc90" tabindex="-1" placeholder="Email" style="border-color: rgba(0,0,0,0.5);" class="form-control text-white-05" required>
                      </div>
                        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_2db886e44db15e869246f6964_871dc3bc90" tabindex="-1" value=""></div>
                        <div class="clear"><input type="submit" value="Claim your interest" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary btn-block offset-top-35"></div>
                    </form>
                    
                </div>
            </div>
        </div>
    </section>

    <section class="text-center section-30">
        <div class="shell">
            <h3 class="text-blue"><small class="text-capitalize">Balance</small></h3>
            <div class="range range-sm-left">
                <p style="font-size: 24px;" class="cell-sm-12 text-left text-blue">My Dentacoin Balance</p>
                <div class="cell-sm-12">
                    <div id="checkBalanceResponse" class="form-group">
                        <h3 id="checkBalanceResponse_body"></h3>
                    </div>
                    <div class="divider-fullwidth bg-porcelain"></div>
                    <h4 id="myAddress" class="text-center"></h4>
                </div>
            </div>
        </div>
    </section>

    <section class="text-center section-30">
        <div class="shell">
            <h3 class="text-blue"><small class="text-capitalize">Transfer</small></h3>
            <div class="range range-sm-left">
                <p style="font-size: 24px;" class="cell-sm-12 text-left text-blue">Transfer Dentacoins</p>
                <p class="text-bold cell-sm-12 text-left text-blue offset-top-15">DCN address of receiver</p>
                <div class="cell-sm-12">
                    <div id="checkBalanceResponse" class="form-group">
                        <input type="text" id="_transferAccount" placeholder="0x0000000000000000000000000000000000000000" class="form-control text-blue"/>
                        <div class="divider-fullwidth bg-porcelain"></div>
                    </div>
                </div>
                <p class="text-bold cell-sm-12 text-left text-blue offset-top-15">Amount</p>
                <div class="cell-sm-12">
                    <div class="form-group">
                        <input type="number" id="_transferAmount" placeholder="Minimum 10 ٨" class="form-control text-blue" style="color: #126585;" />
                        <div class="divider-fullwidth bg-porcelain"></div>
                    </div>
                    <div class="range" style="margin: 0;">
                        <div class="lead about-text cell-sm-4 cell-md-3 cell-lg-2 offset-top-0 offset-sm-top-0 offset-xl-top-0">
                            <button id="_transfer" class="btn btn-primary btn-block offset-top-35">Transfer</button>
                        </div>
                        <div id="transferTokenResponse" class="alert alert-success">
                            <h4>Transfer Dentacoins</h4>
                            <p id="transferTokenResponse_body"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="text-center section-30">
        <div class="shell">
            <h3 class="text-blue"><small class="text-capitalize">Total Supply Allocation</small></h3>
            <div class="range range-sm-left">
                <div class="col-md-10 col-md-offset-1 clearfix">
                    <div id="chart_div" class="chart" align='center' style="margin: 0 auto;"></div>
                    <p class="lead about-text text-center">
                    Trade Dentacoins on exchanges like
                      <a class="text-blue" href="https://etherdelta.github.io/#DCN-ETH" target="_blank">EtherDelta</a>,
                      <a class="text-blue" href="https://www.cryptopia.co.nz/" target="_blank">Cryptopia</a>,
                      <a class="text-blue" href="https://mercatox.com/exchange/DCN/BTC" target="_blank">Mercatox</a>,
                      <a class="text-blue" href="https://www.coinexchange.io/" target="_blank">Coinexchange</a>
                    </p>
                    <p class="lead about-text text-center">
                    or check your existing Dentacoin <a class="text-blue" href="https://michaelsnoeren.nl/dcn/" target="_blank">investment</a>
                    </p>
                    <p class="lead about-text text-center">
                      You don't trust this currency? You're right! Verify it on <a class="text-blue" href="https://etherscan.io/token/0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6" target="_blank">Etherscan</a>
                    </p>
                </div>
            </div>
        </div>
            <h4 class="text-center scrollme animateme text-blue text-light"
            data-when="enter"
            data-from="0.3"
            data-to="0"
            data-easing="easeinout"
            data-opacity="0"
            data-scale="1.5"
            data-translatey="50"
            >Industry network
        </h4>
        <div class="row" style="margin-bottom: 40px;" id="network">
          <div class="col-sm-3 scrollme animateme text-center">
          </div>
          <div class="col-sm-1 scrollme animateme text-center">
              <img src="../industry network/2.png">
          </div>
          <div class="col-sm-1 scrollme animateme text-center">
              <img src="../industry network/3.png">
          </div>
          <div class="col-sm-1 scrollme animateme text-center">
              <img src="../industry network/4.png">
          </div>
          <div class="col-sm-1 scrollme animateme text-center">
              <img src="../industry network/5.png">
          </div>
          <div class="col-sm-1 scrollme animateme text-center">
              <img src="../industry network/6.png">
          </div>
          <div class="col-sm-1 scrollme animateme text-center">
              <img src="../industry network/8.png">
          </div>
          <div class="col-sm-2 scrollme animateme text-center">
          </div>
        </div>
        <div class="range range-sm-center">
                <div class="lead about-text cell-sm-4 cell-md-3 cell-lg-2 offset-top-0 offset-sm-top-0 offset-xl-top-0" id="mc_embed_signup">
                    <form class="validate form-modern form-inverse offset-top-30" novalidate="">
                        <div class="clear"><a href="https://dentacoin.com/conferences/" target="_blank" class="btn btn-primary btn-block offset-top-35">Meet the Team</a></div>
                    </form>
                </div>
        </div>
    </section>

    <footer style="background-color:transparent;" class="page-foot bg-cape-cod context-dark">
        <div class="shell">
        </div>
        <section class="offset-top-60">
          <div class="shell text-center">
            <div class="range range-sm-reverse range-sm-justify range-sm-middle">
              <div class="cell-sm-12 text-sm-center">
                <div class="group-sm group-middle">
                  <p class=""><small>© Dentacoin Foundation. All rights reserved. <br>
                    <a href="..\docs\Dentacoin foundation.pdf" target="_Blank">The Netherlands Chamber of Commerce Business Register extract</a> <br>
                    Wim Duisenbergplantsoen 31 6221 SE Maastricht The Netherlands</small>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>
    </footer>

    <!-- scripts -->
    <script src="../web/js2/dApp.js"></script>
    <script src="../web/js2/core.min.js"></script>
    <script src="../web/js2/min.script.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../web/js2/chart.js"></script>
    <script src="../web/js2/jquery.scrollme.min.js"></script>
    <script src='https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js'></script>
    <script src="../web/js2/particles.js"></script>
    <!-- My small chat slack -->
    <script src="https://embed.small.chat/T4D2LT0D6G6CR1S32A.js" async></script>
  </body>
</html>
