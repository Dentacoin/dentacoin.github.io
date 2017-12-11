
// Total amount: Fixed amount of ever existing Dentacoins
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "https://api.etherscan.io/api?module=stats&action=tokensupply&contractaddress=0x08d32b0da63e2C3bcF8019c9c5d849d7a9d791e6&apikey=NBI9SGSW6P1NZQGYT8BD8DDN5UQ7AIM4E9", false);
      xhr.send();
      var json = JSON.parse(xhr.responseText);
      var totalAmount = parseInt(json.result);

/*
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
*/





      var lockedAmounts = 6088888888873;
      
      var coinOptionPlan = 400000000000;
      var coreTeam1 = 80000000000;
      var coreTeam2 = 80000000000;
      var coreTeam3 = 80000000000;
      var coreTeam4 = 80000000000;
      var coreTeam5 = 80000000000;
      var icoTotal = 240000000000;
      var futureNeeds1 = 312015856340;
      var futureNeeds2 = 16000000000;
      var dentaprime = 240000000000;

      var icoDistributed = 0;




      var circulatingAmount = totalAmount - (lockedAmounts+coinOptionPlan+coreTeam1+coreTeam2+coreTeam3+coreTeam4+coreTeam5+icoTotal+futureNeeds1+futureNeeds2+dentaprime-icoDistributed);

      document.getElementById("circulatingDCN").innerHTML = circulatingAmount;
      document.getElementById("totalDCN").innerHTML = totalAmount;
      document.getElementById("lockedDCN").innerHTML = lockedAmounts;
