<!DOCTYPE html>
<html lang="en" class="wide wow-animation">
  <head>
    <title>Dentacoin Wallet</title>
    <meta name="google-site-verification" content="WdJb5v0M6eYSaSR7WAsTYJkS-MQ-R8ZWZX7jw_eY4Us" />
    <meta name="description" content="The first blockchain solution for the global dental industry.">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="https://dentacoin.com/web/img/favicon.ico" type="image/x-icon">

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-97167262-1', 'auto');
        ga('send', 'pageview');
    </script>
  </head>
  <body style="padding: 0;">
    <div class="page">
    <header class="page-head">

    </header>

    <section id="balance" class="text-center section-30 offset-top-50">
        <div class="shell">
            <div id="checkMetamask" class="alert alert-success">
              <h4>Get <a class="text-underline" href="https://chrome.google.com/webstore/detail/metamask/nkbihfbeogaeaoehlefnkodbefgpgknn" target="_blank">METAMASK</a> to check your balance and transfer DCN</h4>
            </div>
            <h3 class="text-blue" style="font-weight: 300;">Balance</h3>
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

    <section id="transfer" class="text-center section-30">
        <div class="shell">
            <h3 class="text-blue" style="font-weight: 300;">Transfer</h3>
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







    <!-- scripts -->
    <script src="/src/js/dApp.js"></script>

 </body>
</html>
