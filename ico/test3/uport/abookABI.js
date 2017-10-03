var abookABI = [{
    "constant": false,
    "inputs": [{
        "name": "_name",
        "type": "bytes32"
    }],
    "name": "getAddress",
    "outputs": [{
        "name": "_address",
        "type": "address"
    }],
    "payable": false,
    "type": "function"
}, {
    "constant": false,
    "inputs": [{
        "name": "_name",
        "type": "bytes32"
    }],
    "name": "cleanUp",
    "outputs": [{
        "name": "removed",
        "type": "bool"
    }],
    "payable": false,
    "type": "function"
}, {
    "constant": false,
    "inputs": [{
        "name": "_newName",
        "type": "bytes32"
    }],
    "name": "addAddress",
    "outputs": [{
        "name": "added",
        "type": "bool"
    }],
    "payable": false,
    "type": "function"
}, {
    "constant": true,
    "inputs": [],
    "name": "owner",
    "outputs": [{
        "name": "",
        "type": "address",
        "value": ""
    }],
    "payable": false,
    "type": "function"
}, {
    "constant": false,
    "inputs": [{
        "name": "_name",
        "type": "bytes32"
    }],
    "name": "removeAddress",
    "outputs": [{
        "name": "removed",
        "type": "bool"
    }],
    "payable": false,
    "type": "function"
}, {
    "constant": true,
    "inputs": [{
        "name": "",
        "type": "bytes32"
    }],
    "name": "addressOf",
    "outputs": [{
        "name": "",
        "type": "address",
        "value": ""
    }],
    "payable": false,
    "type": "function"
}, {
    "constant": false,
    "inputs": [{
        "name": "newOwner",
        "type": "address"
    }],
    "name": "transferOwnership",
    "outputs": [],
    "payable": false,
    "type": "function"
}];
