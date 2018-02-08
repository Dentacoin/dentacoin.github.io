pragma solidity ^0.4.19;

contract DCNTrader
{
    struct depot
    {
        string info;
        address seller;
        address buyer;
        uint sellerDeposit;
        uint buyerDeposit;
        bool sellerConfirmed;
        bool buyerConfirmed;
    }
    mapping(uint=>depot) public Depots;
    uint depotCount;


    function newSellerDepot() public payable returns (uint depotId)
    {
        depotId = depotCount++;
        Depots[depotId].seller = msg.sender;
        Depots[depotId].sellerDeposit = msg.value;
        return depotId;
    }
    function buyerDeposit(uint depotId) public payable returns (bool done)
    {
        depot storage d = Depots[depotId];
        require (d.sellerDeposit > 0 && d.buyerDeposit == 0);
        require (msg.sender != d.seller);
        require (msg.value == d.sellerDeposit);

        d.buyer = msg.sender;
        d.buyerDeposit = msg.value;
        return true;
    }

    function confirmPayment(uint depotId) public returns (bool done)
    {
        depot storage d = Depots[depotId];

        if((msg.sender == d.seller) && d.buyerDeposit == d.sellerDeposit)
        {
            d.sellerConfirmed = true;
        }

        if((msg.sender == d.buyer) && d.buyerDeposit == d.sellerDeposit)
        {
            d.buyerConfirmed = true;
        }

        if (d.buyerConfirmed && d.sellerConfirmed) {
          var buyerPayout = d.buyerDeposit;
          var sellerPayout = d.sellerDeposit;
          d.buyerDeposit = 0;
          d.sellerDeposit = 0;

          d.buyer.transfer(buyerPayout);
          d.seller.transfer(sellerPayout);

          d.info = "trade successfull";
          return true;
        }
    }

    function cancelDeposit(uint depotId) public returns (bool done)
    {
        depot storage d = Depots[depotId];
        require (msg.sender == d.buyer || msg.sender == d.seller);
        require (!d.buyerConfirmed || !d.sellerConfirmed);

        var buyerPayout = d.buyerDeposit;
        var sellerPayout = d.sellerDeposit;
        d.buyerDeposit = 0;
        d.sellerDeposit = 0;

        if (buyerPayout > 0) {
            d.buyer.transfer(buyerPayout);
        }
        if (sellerPayout > 0) {
            d.seller.transfer(sellerPayout);
        }

        d.info = "depot emptied, deposit refunded.";
        return true;
    }
}
