
    // Dentacoin contract address
    var DCNaddress = "0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6"
    // set web3 object
    //var web3 = typeof window.web3 !== 'undefined' ? window.web3 : new Web3();

    /* setup web3 provider

        if(typeof web3 !== 'undefined') {
          var web3 = new Web3(web3.currentProvider);
        } else {
          web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
        }
*/

window.addEventListener('load', function() {

  // Checking if Web3 has been injected by the browser (Mist/MetaMask)
  if (typeof web3 !== 'undefined') {
    // Use Mist/MetaMask's provider
    window.web3 = new Web3(web3.currentProvider);
  } else {
    console.log('No web3? You should consider trying MetaMask!')
    // fallback - use your fallback strategy (local node / hosted node + in-dapp id mgmt / fail)
    window.web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
  }

    // hide all messages
    $("#newTokenResponse").hide();
    $("#transferTokenResponse").hide();
    $("#buyTokenResponse").hide();
    $("#sellTokenResponse").hide();
    //$("#checkBalanceResponse").hide();


    // setup token ABIs
    var tokenABI =[{"constant":true,"inputs":[],"name":"sellPriceEth","outputs":[{"name":"","type":"uint256"}],"payable":false,"type":"function"},{"constant":false,"inputs":[],"name":"buyDentacoinsAgainstEther","outputs":[{"name":"amount","type":"uint256"}],"payable":true,"type":"function"},{"constant":true,"inputs":[],"name":"name","outputs":[{"name":"","type":"string"}],"payable":false,"type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_value","type":"uint256"}],"name":"approve","outputs":[{"name":"success","type":"bool"}],"payable":false,"type":"function"},{"constant":false,"inputs":[{"name":"newGasReserveInWei","type":"uint256"}],"name":"setGasReserve","outputs":[],"payable":false,"type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"type":"function"},{"constant":false,"inputs":[{"name":"_from","type":"address"},{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transferFrom","outputs":[{"name":"success","type":"bool"}],"payable":false,"type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint8"}],"payable":false,"type":"function"},{"constant":false,"inputs":[{"name":"newDCNAmount","type":"uint256"}],"name":"setDCNForGas","outputs":[],"payable":false,"type":"function"},{"constant":true,"inputs":[],"name":"directTradeAllowed","outputs":[{"name":"","type":"bool"}],"payable":false,"type":"function"},{"constant":true,"inputs":[],"name":"minBalanceForAccounts","outputs":[{"name":"","type":"uint256"}],"payable":false,"type":"function"},{"constant":false,"inputs":[{"name":"newBuyPriceEth","type":"uint256"},{"name":"newSellPriceEth","type":"uint256"}],"name":"setEtherPrices","outputs":[],"payable":false,"type":"function"},{"constant":true,"inputs":[],"name":"buyPriceEth","outputs":[{"name":"","type":"uint256"}],"payable":false,"type":"function"},{"constant":false,"inputs":[{"name":"amountOfEth","type":"uint256"},{"name":"dcn","type":"uint256"}],"name":"refundToOwner","outputs":[],"payable":false,"type":"function"},{"constant":false,"inputs":[{"name":"newGasAmountInWei","type":"uint256"}],"name":"setGasForDCN","outputs":[],"payable":false,"type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"}],"name":"balanceOf","outputs":[{"name":"balance","type":"uint256"}],"payable":false,"type":"function"},{"constant":false,"inputs":[{"name":"amount","type":"uint256"}],"name":"sellDentacoinsAgainstEther","outputs":[{"name":"revenue","type":"uint256"}],"payable":false,"type":"function"},{"constant":false,"inputs":[],"name":"haltDirectTrade","outputs":[],"payable":false,"type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string"}],"payable":false,"type":"function"},{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transfer","outputs":[{"name":"success","type":"bool"}],"payable":false,"type":"function"},{"constant":true,"inputs":[],"name":"DentacoinAddress","outputs":[{"name":"","type":"address"}],"payable":false,"type":"function"},{"constant":true,"inputs":[],"name":"DCNForGas","outputs":[{"name":"","type":"uint256"}],"payable":false,"type":"function"},{"constant":true,"inputs":[],"name":"gasForDCN","outputs":[{"name":"","type":"uint256"}],"payable":false,"type":"function"},{"constant":false,"inputs":[{"name":"minimumBalanceInWei","type":"uint256"}],"name":"setMinBalance","outputs":[],"payable":false,"type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"},{"name":"_spender","type":"address"}],"name":"allowance","outputs":[{"name":"remaining","type":"uint256"}],"payable":false,"type":"function"},{"constant":false,"inputs":[],"name":"unhaltDirectTrade","outputs":[],"payable":false,"type":"function"},{"constant":true,"inputs":[],"name":"gasReserve","outputs":[{"name":"","type":"uint256"}],"payable":false,"type":"function"},{"constant":false,"inputs":[{"name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"type":"function"},{"inputs":[],"payable":false,"type":"constructor"},{"payable":true,"type":"fallback"},{"anonymous":false,"inputs":[{"indexed":true,"name":"_from","type":"address"},{"indexed":true,"name":"_to","type":"address"},{"indexed":false,"name":"_value","type":"uint256"}],"name":"Transfer","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"_owner","type":"address"},{"indexed":true,"name":"_spender","type":"address"},{"indexed":false,"name":"_value","type":"uint256"}],"name":"Approval","type":"event"}];



    // the selected account instance
//    var selectedAccount;

    // setup Token contract factory
    var Token = web3.eth.contract(tokenABI);


    // setup token instance
    var token = Token.at(DCNaddress);

    var account;


    // get accounts
			web3.eth.getAccounts(function(error, accounts){
				console.log(accounts);
				account = accounts[0];
				transactionObject.from = account;
			});



    // setup transaction object
    var transactionObject = {
        from: account,
        gas: 200000
    };






    //var account = web3.eth.accounts[0];
    var accountInterval = setInterval(function() {

      //auto refresh account
      web3.eth.getAccounts(function(error, accounts){
				console.log(accounts);
				account = accounts[0];
				transactionObject.from = account;
			});
      // auto refresh address
      $("#myAddress").html(account);

      //auto refresh balance
      token.balanceOf(account, function(error, balance){
          return $("#checkBalanceResponse_body").html(String(balance.toString(10)) + " ٨");
      });

      /* auto buy price refresh
      token.buyPriceEth(function(error, buypr){
          var res = "1 ETH = " + (1000000000000000000/buypr) + " DCN"
          return $("#_buyAmount").attr('placeholder', res)
      });
      // auto sell price refresh
      token.sellPriceEth(function(error, sellpr){
          var res = (1000000000000000000/sellpr) + " DCN = 1 ETH"
          return $("#_sellAmount").attr('placeholder', res)
      }); */


    }, 3000);




    $("#txHistory").click(function(){
        return window.location = "https://etherscan.io/token/0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6?a=" + account;
    });




// Transfer Dentacoins
    $("#_transfer").click(function(){
        var address = $("#_transferAccount").val(),
        amount = parseInt($("#_transferAmount").val());

        var isAddress = web3.isAddress(address);
        var minAmount = 10;

        if (!isAddress) {
          $("#transferTokenResponse").show();
          return $("#transferTokenResponse_body").html("The entered address is not valid.");
        }
        if (amount < minAmount) {
          $("#transferTokenResponse").show();
          return $("#transferTokenResponse_body").html("The minimum amount to send is 10 ٨.");
        }

        console.log("Transfer Details", address, amount);

        // transfer tokens
        token.transfer(address, amount, transactionObject, function(error, transactionHash){

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


/*

// Buy Dentacoins
    $("#_buy").click(function(){
              var amount = parseFloat($("#_buyAmount").val());


        console.log("Transfer Details", account, amount);

        // transfer ether
        token.buyDentacoinsAgainstEther({value: web3.toWei(amount, "ether"), gas: 200000}, function(error, transactionHash){
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
*/

});
