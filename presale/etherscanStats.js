
  var blink = 0;

  function stats() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&address=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&tag=latest&apikey=NBI9SGSW6P1NZQGYT8BD8DDN5UQ7AIM4E9", false);
    xhr.send();

    var xhr2 = new XMLHttpRequest();
    xhr2.open("GET", "https://api.etherscan.io/api?module=account&action=balance&address=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&tag=latest&apikey=NBI9SGSW6P1NZQGYT8BD8DDN5UQ7AIM4E9", false);
    xhr2.send();

    var xhr3 = new XMLHttpRequest();
    xhr3.open("GET", "https://api.etherscan.io/api?module=account&action=txlist&address=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&startblock=3956814&sort=asc&apikey=NBI9SGSW6P1NZQGYT8BD8DDN5UQ7AIM4E9", false);
    xhr3.send();

    var json = JSON.parse(xhr.responseText);
    var json2 = JSON.parse(xhr2.responseText);
    var json3 = JSON.parse(xhr3.responseText);

    var amountDCN = parseInt(json.result);
    var amountETH = parseInt(json2.result)/1000000000000000000;
    var percent = (80000000000-amountDCN)/80000000000*100;
    var txCount = Object.keys(json3.result).length;
    document.getElementById("txCount").innerHTML = txCount + " contributions";
  }


  stats();
  var refreshStats = setInterval(function() {
    stats();
  }, 10000);
