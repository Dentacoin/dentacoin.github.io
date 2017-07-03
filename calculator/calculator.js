function calculate() {
    var input = document.getElementById("input").value;
    var value = 284;
    var usd = (value * 100) * input;
    var cents = (value * 10) * input;
    var cent = value * input;
    var dcn = 28400 * input;
    document.getElementById('usd').innerHTML = "$ " + usd;
    document.getElementById('cents').innerHTML = "$ " + cents;
    document.getElementById('cent').innerHTML = "$ " + cent;
    document.getElementById('dcn').innerHTML = "= "+ dcn + " DCN";
}
