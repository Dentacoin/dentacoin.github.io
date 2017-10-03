/*
var xhrEUR = new XMLHttpRequest();
xhrEUR.open("GET", "https://api.coinmarketcap.com/v1/ticker/dentacoin/?convert=EUR", false);
xhrEUR.send();

var jsonEUR = JSON.parse(xhrEUR.responseText);
var eurPrice = parseFloat(jsonEUR[0].price_eur);
document.getElementById("eurPrice").innerHTML = eurPrice + " €  /  ";

*/


var xhrUSD = new XMLHttpRequest();
xhrUSD.open("GET", "https://api.coinmarketcap.com/v1/ticker/dentacoin/?convert=USD", false);
xhrUSD.send();

var jsonUSD = JSON.parse(xhrUSD.responseText);
var usdPrice = parseFloat(jsonUSD[0].price_usd);
document.getElementById("usdPrice").innerHTML = usdPrice + " $";
