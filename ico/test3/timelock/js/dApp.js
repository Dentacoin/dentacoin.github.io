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


    let abi = [ { "constant": true, "inputs": [], "name": "lockTime", "outputs": [ { "name": "", "type": "uint256", "value": "600" } ], "payable": false, "type": "function" }, { "constant": false, "inputs": [], "name": "withdraw", "outputs": [], "payable": false, "type": "function" }, { "constant": true, "inputs": [], "name": "startTime", "outputs": [ { "name": "", "type": "uint256", "value": "1502497439" } ], "payable": false, "type": "function" }, { "constant": true, "inputs": [], "name": "owner", "outputs": [ { "name": "", "type": "address", "value": "0x8196cd5fe0eec770de925be7a6d0fc79d06ef891" } ], "payable": false, "type": "function" }, { "constant": true, "inputs": [], "name": "tokenAddress", "outputs": [ { "name": "", "type": "address", "value": "0x2debb13bcf5526e0cf5e3a4e5049100e3f7c2ae5" } ], "payable": false, "type": "function" }, { "inputs": [], "payable": false, "type": "constructor" }, { "payable": true, "type": "fallback" } ];

    let bytecode = "6060604052610258600155341561001557600080fd5b5b336000806101000a81548173ffffffffffffffffffffffffffffffffffffffff021916908373ffffffffffffffffffffffffffffffffffffffff16021790555042600281905550732debb13bcf5526e0cf5e3a4e5049100e3f7c2ae5600460006101000a81548173ffffffffffffffffffffffffffffffffffffffff021916908373ffffffffffffffffffffffffffffffffffffffff1602179055505b5b61046a806100c36000396000f3006060604052361561006b576000357c0100000000000000000000000000000000000000000000000000000000900463ffffffff1680630d6680871461006f5780633ccfd60b1461009857806378e97925146100ad5780638da5cb5b146100d65780639d76ea581461012b575b5b5b005b341561007a57600080fd5b610082610180565b6040518082815260200191505060405180910390f35b34156100a357600080fd5b6100ab610186565b005b34156100b857600080fd5b6100c06103ed565b6040518082815260200191505060405180910390f35b34156100e157600080fd5b6100e96103f3565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b341561013657600080fd5b61013e610418565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b60015481565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff168073ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff161415156101e257600080fd5b42600154600254011015156101f657600080fd5b600460009054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff166370a08231306000604051602001526040518263ffffffff167c0100000000000000000000000000000000000000000000000000000000028152600401808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff168152602001915050602060405180830381600087803b15156102bb57600080fd5b6102c65a03f115156102cc57600080fd5b50505060405180519050600381905550600460009054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff1663a9059cbb6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff166003546000604051602001526040518363ffffffff167c0100000000000000000000000000000000000000000000000000000000028152600401808373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200182815260200192505050602060405180830381600087803b15156103cc57600080fd5b6102c65a03f115156103dd57600080fd5b50505060405180519050505b5b50565b60025481565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1681565b600460009054906101000a900473ffffffffffffffffffffffffffffffffffffffff16815600a165627a7a72305820d181340ca991dc0ebb8b2742db847665788b00549ef8cce4df13f8978021ac8c0029";


    // hide all messages
    $("#newTokenResponse").hide();
    $("#transferTokenResponse").hide();
    $("#buyTokenResponse").hide();
    $("#sellTokenResponse").hide();
    //$("#checkBalanceResponse").hide();




    var account = web3.eth.accounts[0];
    var myContractReturned = "";





    var accountInterval = setInterval(function() {

      //auto refresh account
      if (web3.eth.accounts[0] !== account) {
        account = web3.eth.accounts[0];
      }
      // auto refresh address
      $("#myAddress").html(account);
    }, 1000);






//manual Check balance      uncomment button in index.html
    $("#_checkBalance").click(function(){

    let MyContract = web3.eth.contract(abi);

    myContractReturned = MyContract.new({
 from:account,
 data:bytecode,
 gas:200000}, function(err, myContract){
  if(!err) {
     // NOTE: The callback will fire twice!
     // Once the contract has the transactionHash property set and once its deployed on an address.

     // e.g. check tx hash on the first call (transaction send)
     if(!myContract.address) {
         console.log(myContract.transactionHash); // The hash of the transaction, which deploys the contract

     // check address on the second call (contract deployed)
     } else {
         console.log(myContract.address); // the contract address
         //return $("#checkBalanceResponse_body").html(String(myContract.address));
     }

     // Note that the returned "myContractReturned" === "myContract",
     // so the returned "myContractReturned" object will also get the address set.
  }
});
});
//- Check balance





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

})
