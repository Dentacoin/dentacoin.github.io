// Mercatox ETH & BTC
var xhr = new XMLHttpRequest();
xhr.open("GET", "https://mercatox.com/public/dentacoin", false);
xhr.send();
var json = JSON.parse(xhr.responseText);
var mercatoxBTC = parseInt(json.DCN_BTC);
var mercatoxETH = parseInt(json.DCN_ETH);

// document.getElementById("mercatoxBTC").innerHTML = mercatoxBTC;
// document.getElementById("mercatoxETH").innerHTML = mercatoxETH;


// //Website – ETH
// var xhr2 = new XMLHttpRequest();
// xhr2.open("GET", "https://api.etherscan.io/api?module=account&action=balance&address=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&tag=latest&apikey=NBI9SGSW6P1NZQGYT8BD8DDN5UQ7AIM4E9", false);
// xhr2.send();
// var json2 = JSON.parse(xhr2.responseText);
// var websiteETH = parseInt(json2.result);

// document.getElementById("websiteETH").innerHTML = websiteETH;


//BuyUcoin - IRN
var xhr3 = new XMLHttpRequest();
xhr3.open("GET", "https://www.buyucoin.com/api/v1/dcn/volume", false);
xhr3.send();
var json2 = JSON.parse(xhr3.responseText);
var buyucoinIRN = parseInt(json2.vol);

// document.getElementById("buyucoinIRN").innerHTML = buyucoinIRN;


var amountDCN = mercatoxBTC + mercatoxETH + buyucoinIRN + 100000000000;
var elem = document.getElementById("progress");
var width = (((240000000000-amountDCN)/240000000000*100) - 100) * (-1);


elem.style.width = width + '%';
elem.innerHTML = (width * 1).toFixed(2) + '%';