$("#newTokenResponse").hide();$("#transferTokenResponse").hide();$("#buyTokenResponse").hide();$("#sellTokenResponse").hide();$("#checkMetamask").hide();var DCNaddress="0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6"
if(typeof window.web3.currentProvider!=='undefined'){web3.setProvider(window.web3.currentProvider)}
else{$("#checkMetamask").show();web3.setProvider(new web3.providers.HttpProvider('http://localhost:8545'))}
var tokenABI=[{"constant":!0,"inputs":[],"name":"sellPriceEth","outputs":[{"name":"","type":"uint256","value":"1000000000000000"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[],"name":"buyDentacoinsAgainstEther","outputs":[{"name":"amount","type":"uint256"}],"payable":!0,"type":"function"},{"constant":!0,"inputs":[],"name":"name","outputs":[{"name":"","type":"string","value":"Dentacoin"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[{"name":"_spender","type":"address"},{"name":"_value","type":"uint256"}],"name":"approve","outputs":[{"name":"success","type":"bool"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[{"name":"newGasReserveInWei","type":"uint256"}],"name":"setGasReserve","outputs":[],"payable":!1,"type":"function"},{"constant":!0,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256","value":"8000000000000"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[{"name":"_from","type":"address"},{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transferFrom","outputs":[{"name":"success","type":"bool"}],"payable":!1,"type":"function"},{"constant":!0,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint8","value":"0"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[{"name":"newDCNAmount","type":"uint256"}],"name":"setDCNForGas","outputs":[],"payable":!1,"type":"function"},{"constant":!0,"inputs":[],"name":"directTradeAllowed","outputs":[{"name":"","type":"bool","value":!0}],"payable":!1,"type":"function"},{"constant":!0,"inputs":[],"name":"minBalanceForAccounts","outputs":[{"name":"","type":"uint256","value":"10000000000000000"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[{"name":"newBuyPriceEth","type":"uint256"},{"name":"newSellPriceEth","type":"uint256"}],"name":"setEtherPrices","outputs":[],"payable":!1,"type":"function"},{"constant":!0,"inputs":[],"name":"buyPriceEth","outputs":[{"name":"","type":"uint256","value":"1000000000000000"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[{"name":"amountOfEth","type":"uint256"},{"name":"dcn","type":"uint256"}],"name":"refundToOwner","outputs":[],"payable":!1,"type":"function"},{"constant":!1,"inputs":[{"name":"newGasAmountInWei","type":"uint256"}],"name":"setGasForDCN","outputs":[],"payable":!1,"type":"function"},{"constant":!0,"inputs":[{"name":"_owner","type":"address"}],"name":"balanceOf","outputs":[{"name":"balance","type":"uint256","value":"0"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[{"name":"amount","type":"uint256"}],"name":"sellDentacoinsAgainstEther","outputs":[{"name":"revenue","type":"uint256"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[],"name":"haltDirectTrade","outputs":[],"payable":!1,"type":"function"},{"constant":!0,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address","value":"0xc99f67433019d1da18c311e767faa2b8ec250886"}],"payable":!1,"type":"function"},{"constant":!0,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string","value":"٨"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transfer","outputs":[{"name":"success","type":"bool"}],"payable":!1,"type":"function"},{"constant":!0,"inputs":[],"name":"DentacoinAddress","outputs":[{"name":"","type":"address","value":"0x08d32b0da63e2c3bcf8019c9c5d849d7a9d791e6"}],"payable":!1,"type":"function"},{"constant":!0,"inputs":[],"name":"DCNForGas","outputs":[{"name":"","type":"uint256","value":"10"}],"payable":!1,"type":"function"},{"constant":!0,"inputs":[],"name":"gasForDCN","outputs":[{"name":"","type":"uint256","value":"5000000000000000"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[{"name":"minimumBalanceInWei","type":"uint256"}],"name":"setMinBalance","outputs":[],"payable":!1,"type":"function"},{"constant":!0,"inputs":[{"name":"_owner","type":"address"},{"name":"_spender","type":"address"}],"name":"allowance","outputs":[{"name":"remaining","type":"uint256","value":"0"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[],"name":"unhaltDirectTrade","outputs":[],"payable":!1,"type":"function"},{"constant":!0,"inputs":[],"name":"gasReserve","outputs":[{"name":"","type":"uint256","value":"100000000000000000"}],"payable":!1,"type":"function"},{"constant":!1,"inputs":[{"name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":!1,"type":"function"},{"inputs":[],"payable":!1,"type":"constructor"},{"payable":!0,"type":"fallback"},{"anonymous":!1,"inputs":[{"indexed":!0,"name":"_from","type":"address"},{"indexed":!0,"name":"_to","type":"address"},{"indexed":!1,"name":"_value","type":"uint256"}],"name":"Transfer","type":"event"},{"anonymous":!1,"inputs":[{"indexed":!0,"name":"_owner","type":"address"},{"indexed":!0,"name":"_spender","type":"address"},{"indexed":!1,"name":"_value","type":"uint256"}],"name":"Approval","type":"event"}];var Token=web3.eth.contract(tokenABI);var token=Token.at(DCNaddress);var transactionObject={from:web3.eth.accounts[0],gas:100000};web3.eth.getAccounts(function(error,accounts){console.log(accounts);selectedAccount=accounts[0];transactionObject.from=selectedAccount});var account=web3.eth.accounts[0];var accountInterval=setInterval(function(){if(web3.eth.accounts[0]!==account){account=web3.eth.accounts[0];transactionObject.from=account}
token.balanceOf(account,function(error,balance){return $("#checkBalanceResponse_body").html(String(balance.toString(10))+" ٨")});token.buyPriceEth(function(error,buypr){var res="1 ETH = 2 500 000 DCN"
return $("#_buyAmount").attr('placeholder',res)});token.sellPriceEth(function(error,sellpr){var res=(1000000000000000000/sellpr)+" DCN = 1 ETH"
return $("#_sellAmount").attr('placeholder',res)});$("#myAddress").html(account)},1000);$("#_transfer").click(function(event){event.preventDefault();var account=$("#_transferAccount").val(),amount=parseInt($("#_transferAmount").val());console.log("Transfer Details",account,amount);token.transfer(account,amount,transactionObject,function(error,transactionHash){if(amount<10){$("#transferTokenResponse").show();return $("#transferTokenResponse_body").html("Error: minimum amount 10+"+String(error))}
if(error){$("#transferTokenResponse").show();return $("#transferTokenResponse_body").html("There was an error transfering your Dentacoins: "+String(error))}
$("#transferTokenResponse").show();return $("#transferTokenResponse_body").html("Ok, pending transaction. Give it a minute and check for confirmation on <a href='https://etherscan.io/tx/"+String(transactionHash)+"' target='_blank'>Etherscan</a> ")});token.Transfer({},function(error,result){if(error){$("#transferTokenResponse").show();return $("#transferTokenResponse_body").html("There was an error transfering your Dentacoins: "+String(error))}
$("#transferTokenResponse").show();return $("#transferTokenResponse_body").html("Your Dentacoins have been transfered! "+String(result.transactionHash))})});$("#_buy").click(function(){var amount=parseFloat($("#_buyAmount").val());console.log("Transfer Details",account,amount);token.buyDentacoinsAgainstEther({value:web3.toWei(amount,"ether"),gas:100000},function(error,transactionHash){if(error){$("#buyTokenResponse").show();return $("#buyTokenResponse_body").html("There was an error transfering your ETH: "+String(error))}
$("#buyTokenResponse").show();return $("#buyTokenResponse_body").html("Ok, pending transaction. Give it a minute and check for confirmation on <a href='https://etherscan.io/tx/"+String(transactionHash)+"' target='_blank'>Etherscan</a> ")});token.Transfer({},function(error,result){if(error){$("#buyTokenResponse").show();return $("#buyTokenResponse_body").html("There was an error transfering your ETH: "+String(error))}
$("#buyTokenResponse").show();return $("#buyTokenResponse_body").html("Your ETH have been transfered! "+String(result.transactionHash))})});$("#_sell").click(function(){var amount=parseInt($("#_sellAmount").val());console.log("Transfer Details",amount);token.sellDentacoinsAgainstEther(amount,transactionObject,function(error,transactionHash){if(error){$("#sellTokenResponse").show();return $("#sellTokenResponse_body").html("There was an error selling your Dentacoins. Please check <a href='https://etherscan.io/tx/"+String(transactionHash)+"' target='_blank'>Etherscan</a>")}
$("#sellTokenResponse").show();return $("#sellTokenResponse_body").html("Ok, pending transaction. Give it a minute and check for confirmation on <a href='https://etherscan.io/tx/"+String(transactionHash)+"' target='_blank'>Etherscan</a> then check your balance. ")});token.Transfer({},function(error,result){if(error){$("#sellTokenResponse").show();return $("#sellTokenResponse_body").html("There was an error selling your Dentacoins. Please check <a href='https://etherscan.io/tx/"+String(result.transactionHash)+"' target='_blank'>Etherscan</a>")}
$("#sellTokenResponse").show();return $("#sellTokenResponse_body").html("Your Dentacoins have been sold! "+String(result.transactionHash))})})