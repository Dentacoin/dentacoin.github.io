$(document).ready(function(){
var countDownDate = new Date(Date.UTC(2017, 8, 1, 14));

$("#h_after").hide();
$("#progress-bar").hide();
$("#buy").hide();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now an the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / 86400000);
  var hours = Math.floor((distance % 86400000) / 3600000);
  var minutes = Math.floor((distance % 3600000) / 60000);
  var seconds = Math.floor((distance % 60000) / 1000);

  // Output the result in an element with id="demo"

  // If the count down is over, write some text
  if (distance <= 2) {
    
  clearInterval(x);
  // document.getElementById("time").innerHTML = "O";
  
    $("#h_till").hide();
    $("#time_till").hide();
    $("#h_after").show();
    $("#progress-bar").show();
    $("#buy").show();
    $("#subcribers").hide();
  }
}, 1000);});
