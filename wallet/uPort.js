const uportConnect = require('uport-connect');
const qrcode = require('qrcode-terminal');

const mnidAddress = 'CLIENT_ID';
const signingKey = 'SIGNING_KEY';
const appName = 'NAME_OF_DAPP';

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
