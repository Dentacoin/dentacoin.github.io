var xhr = new XMLHttpRequest();
xhr.open("GET", "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&address=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&tag=latest&apikey=NBI9SGSW6P1NZQGYT8BD8DDN5UQ7AIM4E9", false);
xhr.send();

var json = JSON.parse(xhr.responseText);
var amountDCN = parseInt(json.result);

var elem = document.getElementById("progress");
var width = (80000000000-amountDCN)/80000000000*100;


elem.style.width = width + '%';
elem.innerHTML = (width * 1).toFixed(2) + '%';
