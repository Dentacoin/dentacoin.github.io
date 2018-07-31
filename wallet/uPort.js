const uportConnect = require('uport-connect');
const qrcode = require('qrcode-terminal');

const mnidAddress = '2oqwHbLQ8Ao28LvFFThbd1Jxpj45EBPb8jd';
const signingKey = require('./uPortKey');
const appName = 'Dentacoin Wallet';

const uriHandler = (uri) => {
  qrcode.generate(uri, {small: true})
  console.log(uri)
}

const uport = new uportConnect.Connect(appName, {
    uriHandler,
    clientId: mnidAddress,
    network: 'rinkeby',
    signer: uportConnect.SimpleSigner(signingKey.key)
});

const web3 = uport.getWeb3();
console.log(web3.eth.getCoinbase());


// Request credentials
uport.requestCredentials({
  requested: ['name'],
}).then((credentials) => {
  console.log(credentials);
})
