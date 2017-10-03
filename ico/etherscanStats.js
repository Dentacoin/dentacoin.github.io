
  var blink = 0;

  function stats() {
    var xhr3 = new XMLHttpRequest();
    xhr3.open("GET", "https://api.etherscan.io/api?module=account&action=txlist&address=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&startblock=3956814&sort=asc&apikey=NBI9SGSW6P1NZQGYT8BD8DDN5UQ7AIM4E9", false);
    xhr3.send();

    var json3 = JSON.parse(xhr3.responseText);

    var txCount = Object.keys(json3.result).length;
    document.getElementById("txCount").innerHTML = txCount + " contributions";
  }


  stats();
  var refreshStats = setInterval(function() {
    stats();
  }, 10000);
