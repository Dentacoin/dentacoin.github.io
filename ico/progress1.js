// $(document).ready(function(){

    // $("#progress-comfort").hide();
// ------- Function returning response -------------------------------------
/*function getResponse(_uri) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", _uri, false);
    xhr.send();
    try {
        var json = JSON.parse(xhr.responseText);
    } catch (e) {
        return false;
    }
    return json;
}

*/


function getResponse(_uri) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", _uri, false);

   try {
        xhr.send();
        var json = JSON.parse(xhr.responseText);
    } catch (e) {
        return false;
    }
    return json;
}





var countObjDCN = {};                 // Declare count object

// ------- Add URLs and alias in this array --------------------------------
var urls = {
    etherscan         : "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&address=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&tag=latest&apikey=NBI9SGSW6P1NZQGYT8BD8DDN5UQ7AIM4E9",
    mercatox         : "https://mercatox.com/public/dentacoin",
    buyucoin         : "https://www.buyucoin.com/api/v1/dcn/volume",
    cryptopia         : "https://www.dentacoin.com/cryptopia.txt",
    hitBtc             : "https://dentacoin.com/hitBTC.json",
    coinExchange     : "https://dentacoin.com/coinexchange.txt",
    buyucoin_err_test: "https://www.buyucoin.com/api/v1/dcn/volume"
}

for (var urlAlias in urls) {
    if (urls.hasOwnProperty(urlAlias)) {
        fetchedJsonData = getResponse(urls[urlAlias]);
        if(fetchedJsonData) {
            switch(urlAlias) {
                case 'etherscan':
                    var tmpVal = parseInt(fetchedJsonData.result);
                    countObjDCN.websiteDCN = 96000000000 - tmpVal;
                    break;
                case 'mercatox':
                    countObjDCN.mercatoxDCN = parseInt(fetchedJsonData.total);
                    break;
                case 'buyucoin':
                    countObjDCN.buyucoinDCN = parseInt(fetchedJsonData.vol);
                    break;
                case 'cryptopia':
                    countObjDCN.cryptopiaDCN = parseInt(fetchedJsonData);
                    break;
                case 'hitBtc':
                    countObjDCN.hitBtcDCN = parseInt(fetchedJsonData.dcn);
                    break;
                case 'coinExchange':
                    countObjDCN.coinexchangeDCN = parseInt(fetchedJsonData);
                    break;
                //--- Add new exchange logic -----------------------------------
                /*
                case 'newEchange':
                    countObjDCN.newExchangeDCN = parseInt(fetchedJsonData.property);
                    break;
                */
                default:
                    break;
            }
        }
    }
}

countObjDCN.amountDCN = 0;

for (var countDCN in countObjDCN) {
    if (countObjDCN.hasOwnProperty(countDCN)) {
        if(!isNaN(countObjDCN[countDCN])) {
            if(countDCN != "amountDCN") {
                countObjDCN.amountDCN = countObjDCN.amountDCN + countObjDCN[countDCN];
            }
        } else {
            console.log("Response is not correct for: " + countDCN);
            //--- Redirect to error log with timestamp for tracking --------------------------------
        }
    }
}

var elem = document.getElementById("progress-minimal");
var elem2 = document.getElementById("progress-comfort");
var elem3 = document.getElementById("progress");
elem2.style.visibility = "hidden";
elem3.style.backgroundColor = "grey";
elem3.style.opacity = "0.4";
var width = (240000000000-countObjDCN.amountDCN)/240000000000*100;
width = 100 - width;
var width1;
var width2 = width;
if (width >= 5) {
    width1 = 100;
    elem2.style.visibility = "visible";
    elem3.style.backgroundColor = "#F5F5F5";
    elem3.style.opacity = "unset";
    width2 = width * 5;
    elem.innerHTML = (width1 * 1) + '%';
}
else {
    width1 = width * 20;
    elem.innerHTML = (width1 * 1).toFixed(2) + '%';
}
var dcndest = countObjDCN.amountDCN;
document.getElementById("dcndest").innerHTML = dcndest;


    

    // // if (width <= 5) {
    // //     $("progress").css("background-color", "grey");
    // // }
    
    // if (width1 >= 100) {
      
    //   $("#progress-comfort").show();
    // }


elem.style.width = width1 + '%';

elem2.style.width = width2 + '%';
elem2.innerHTML = (width2 * 1).toFixed(2) + '%';
// });