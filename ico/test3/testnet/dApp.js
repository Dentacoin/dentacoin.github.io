
    // Dentacoin contract address
    var DCNaddress = "0x571280B600bBc3e2484F8AC80303F033b762048f"
    // set web3 object
    var web3 = typeof window.web3 !== 'undefined' ? window.web3 : new Web3();

    // setup metamask provider
    if(typeof window.web3.currentProvider !== 'undefined')
        web3.setProvider(window.web3.currentProvider);
    else
        //web3.setProvider(new web3.providers.HttpProvider('http://159.203.28.215:8545'));
        web3.setProvider(new web3.providers.HttpProvider('http://localhost:8545'));

    // hide all messages
    $("#newTokenResponse").hide();
    $("#transferTokenResponse").hide();
    $("#buyTokenResponse").hide();
    $("#sellTokenResponse").hide();
    //$("#checkBalanceResponse").hide();



    // setup Token contract factory
    var Token = web3.eth.contract(tokenABI);


    // setup token instance
    var token = Token.at(DCNaddress);


    // setup transaction object
    var transactionObject = {
        from: web3.eth.accounts[0],
        gas: 2000000
    };




    var account = web3.eth.accounts[0];
    var accountInterval = setInterval(function() {

      //auto refresh account
      if (web3.eth.accounts[0] !== account) {
        account = web3.eth.accounts[0];
        transactionObject.from = account;
      }

      //auto refresh balance
      token.balanceOf(account, function(error, balance){
          return $("#checkBalanceResponse_body").html(String(balance.toString(10)) + " ٨");
      });

      // auto buy price refresh
      token.buyPriceEth(function(error, buypr){
          var res = "1 ETH = " + (1000000000000000000/buypr) + " DCN"
          return $("#_buyAmount").attr('placeholder', res)
      });

      // auto sell price refresh
      token.sellPriceEth(function(error, sellpr){
          var res = (1000000000000000000/sellpr) + " DCN = 1 ETH"
          return $("#_sellAmount").attr('placeholder', res)
      });

      // auto refresh address
      $("#myAddress").html(account);

    }, 1000);



/*manual Check balance      //uncomment button in index.html
    $("#_checkBalance").click(function(){
        //var account = selectedAccount;

        token.balanceOf(account, function(error, balance){
            //$("#checkBalanceResponse").show();
            return $("#checkBalanceResponse_body").html(String(balance.toString(10)) + " ٨");
        });
    });
//- Check balance
*/


      //web3 info

$("#currentAcc").click(function(){
    return $("#currentAcc").html(account);
});


// Transfer Dentacoins
    $("#_transfer").click(function(){
        var account = $("#_transferAccount").val(),
                amount = parseInt($("#_transferAmount").val());

        console.log("Transfer Details", account, amount);

        // transfer tokens
        token.transfer(account, amount, transactionObject, function(error, transactionHash){
            if(error) {
                $("#transferTokenResponse").show();
                return $("#transferTokenResponse_body").html("There was an error transfering your Dentacoins: " + String(error));
            }

            $("#transferTokenResponse").show();
            //return $("#transferTokenResponse_body").html("Your token is being transfered with tx hash: " + String(transactionHash));
            return $("#transferTokenResponse_body").html("Ok, pending transaction. Give it a minute and check for confirmation on <a href='https://etherscan.io/tx/" + String(transactionHash) + "' target='_blank'>Etherscan</a> ");
        });

        token.Transfer({}, function(error, result){
            if(error) {
                $("#transferTokenResponse").show();
                return $("#transferTokenResponse_body").html("There was an error transfering your Dentacoins: " + String(error));
            }

            $("#transferTokenResponse").show();
            return $("#transferTokenResponse_body").html("Your Dentacoins have been transfered! " + String(result.transactionHash));
        });
    });
//- Transfer Dentacoins




// Buy Dentacoins
    $("#_buy").click(function(){
              var amount = parseFloat($("#_buyAmount").val());


        console.log("Transfer Details", account, amount);

        // transfer ether
        token.buyDentacoinsAgainstEther({value: web3.toWei(amount, "ether"), gas: 2000000}, function(error, transactionHash){
            if(error) {
                $("#buyTokenResponse").show();
                return $("#buyTokenResponse_body").html("There was an error transfering your ETH: " + String(error));
            }

            $("#buyTokenResponse").show();
            return $("#buyTokenResponse_body").html("Ok, pending transaction. Give it a minute and check for confirmation on <a href='https://etherscan.io/tx/" + String(transactionHash) + "' target='_blank'>Etherscan</a> ");

        });
    });
//- Buy Dentacoin




// Sell Dentacoins
    $("#_sell").click(function(){
              var amount = parseInt($("#_sellAmount").val());

        console.log("Transfer Details", amount);

        // transfer tokens
        token.sellDentacoinsAgainstEther(amount, transactionObject, function(error, transactionHash){
            if(error) {
                $("#sellTokenResponse").show();
                //return $("#sellTokenResponse_body").html("There was an error selling your Dentacoins: " + String(error));
                return $("#sellTokenResponse_body").html("There was an error selling your Dentacoins. Please check <a href='https://etherscan.io/tx/" + String(transactionHash) + "' target='_blank'>Etherscan</a>");
            }

            $("#sellTokenResponse").show();
            //return $("#transferTokenResponse_body").html("Your token is being transfered with tx hash: " + String(transactionHash));
            return $("#sellTokenResponse_body").html("Ok, pending transaction. Give it a minute and check for confirmation on <a href='https://etherscan.io/tx/" + String(transactionHash) + "' target='_blank'>Etherscan</a> then check your balance. ");
        });

        token.Transfer({}, function(error, result){
            if(error) {
                $("#sellTokenResponse").show();
                //return $("#sellTokenResponse_body").html("There was an error selling your Dentacoins: " + String(error));
                return $("#sellTokenResponse_body").html("There was an error selling your Dentacoins. Please check <a href='https://etherscan.io/tx/" + String(result.transactionHash) + "' target='_blank'>Etherscan</a>");
            }

            $("#sellTokenResponse").show();
            return $("#sellTokenResponse_body").html("Your Dentacoins have been sold! " + String(result.transactionHash));
        });
    });
//- Sell Dentacoins
