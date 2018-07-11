<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Dentacoin Wallet</title>
    <meta name="google-site-verification" content="WdJb5v0M6eYSaSR7WAsTYJkS-MQ-R8ZWZX7jw_eY4Us" />
    <meta name="description" content="Official Dentacoin Web-App Wallet">
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

  <body>
    <div class="page">

    <header class="page-head">
    </header>

    <section id="balance" class="section">
        <div>
            <h3>Balance</h3>
            <div>
                <p>My Dentacoin Balance</p>
                <div>
                    <div id="checkBalanceResponse">
                        <h3 id="checkBalanceResponse_body"></h3>
                    </div>
                    <div></div>
                    <h4 id="myAddress"></h4>
                </div>
            </div>
        </div>
    </section>

    <section id="transfer" class="section">
        <div class="shell">
            <h3>Transfer</h3>
            <div>
                <p>Transfer Dentacoins</p>
                <p>DCN address of receiver</p>
                <div>
                    <div id="checkBalanceResponse">
                        <input type="text" id="_transferAccount" placeholder="0x0000000000000000000000000000000000000000"/>
                        <div class="divider-fullwidth bg-porcelain"></div>
                    </div>
                </div>
                <p>Amount</p>
                <div>
                    <div>
                        <input type="number" id="_transferAmount" placeholder="Minimum 10 ٨"/>
                        <div></div>
                    </div>
                    <div>
                        <div>
                            <button id="_transfer">Transfer</button>
                        </div>
                        <div id="transferTokenResponse">
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
    <script src="/src/js/jquery-3.2.1.min.js"></script>

 </body>
</html>
