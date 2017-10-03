/*
Dentacoin Foundation TimeLock Contract team accounts

TESTNET rinkeby
*/


pragma solidity ^0.4.11;

//Dentacoin token import
contract exToken {
  function transfer(address, uint256) returns (bool) {  }
  function balanceOf(address) constant returns (uint256) {  }
}


// Timelock
contract DentacoinTimeLock {

  address public owner;
  uint public lockTime = 10 minutes;
  uint public startTime;
  uint256 lockedAmount;
  exToken public tokenAddress;

  modifier onlyBy(address _account){
    require(msg.sender == _account);
    _;
  }

  function () payable {}

  function DentacoinTimeLock() {

    owner = msg.sender;
    startTime = now;
    tokenAddress = exToken(0x2Debb13BCF5526e0cF5E3A4E5049100E3F7c2AE5);
  }

  function withdraw() onlyBy(owner) {
    require ((startTime + lockTime) < now);
    lockedAmount = tokenAddress.balanceOf(this);
    tokenAddress.transfer(owner, lockedAmount);
  }
}
