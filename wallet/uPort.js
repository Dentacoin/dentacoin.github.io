const uportConnect = require('uport-connect');
const qrcode = require('qrcode-terminal');

const mnidAddress = '2oqwHbLQ8Ao28LvFFThbd1Jxpj45EBPb8jd';
//const signingKey = require('./signingKey');
const signingKey = require('./signingKey');
const appName = 'Dentacoin Wallet';

console.log(signingKey);

const uriHandler = (uri) => {
  qrcode.generate(uri, {small: true})
  console.log(uri)
}

const uport = new uportConnect.Connect(appName, {
    uriHandler,
    clientId: mnidAddress,
    network: 'rinkeby',
    signer: uportConnect.SimpleSigner(signingKey)
});

// Request credentials
uport.requestCredentials({
  requested: ['name'],
}).then((credentials) => {
  console.log(credentials);
})
