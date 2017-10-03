
// Total amount: Fixed amount of ever existing Dentacoins
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "https://api.etherscan.io/api?module=stats&action=tokensupply&contractaddress=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&apikey=NBI9SGSW6P1NZQGYT8BD8DDN5UQ7AIM4E9", false);
      xhr.send();
      var json = JSON.parse(xhr.responseText);
      var totalAmount = parseInt(json.result);

// Dentacoins of dcnAdmin
      var xhr2 = new XMLHttpRequest();
      xhr2.open("GET", "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&address=0xc99f67433019D1DA18C311e767FAa2b8EC250886&tag=latest&apikey=NBI9SGSW6P1NZQGYT8BD8DDN5UQ7AIM4E9", false);
      xhr2.send();
      var json2 = JSON.parse(xhr2.responseText);
      var dcnAdmin = parseInt(json2.result);

// Dentacoins of contract
      var xhr3 = new XMLHttpRequest();
      xhr3.open("GET", "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&address=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&tag=latest&apikey=NBI9SGSW6P1NZQGYT8BD8DDN5UQ7AIM4E9", false);
      xhr3.send();
      var json3 = JSON.parse(xhr3.responseText);
      var contractAmount = parseInt(json3.result);

// Dentacoins of ICO
      var xhr4 = new XMLHttpRequest();
      xhr4.open("GET", "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&address=0x0ef583f8D4FA7d26eb746e70Ac88b14C3cc77482&tag=latest&apikey=NBI9SGSW6P1NZQGYT8BD8DDN5UQ7AIM4E9", false);
      xhr4.send();
      var json4 = JSON.parse(xhr4.responseText);
      var ico = parseInt(json4.result);






      var lockedAmounts = 6397904745213;
      var f3tLondon = 79999999990;
      var klinik1 = 3000000030;
      var swissDP = 79999999990;
      var futureTeam = 399999999990;
      var southSummer = 239999999990;
      var villaM = 7999999990;
      var adVarna = 31506350321;
      var dpCity = 79999999990;

      var circulatingAmount = totalAmount - (lockedAmounts+contractAmount+dcnAdmin+f3tLondon+klinik1+ico+swissDP+futureTeam+southSummer+villaM+adVarna+dpCity);

      document.getElementById("circulatingDCN").innerHTML = circulatingAmount;
      document.getElementById("totalDCN").innerHTML = totalAmount;
      document.getElementById("lockedDCN").innerHTML = lockedAmounts;