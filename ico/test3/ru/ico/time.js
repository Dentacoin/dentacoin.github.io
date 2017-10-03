var countDownDate = new Date(Date.UTC(2017, 7, 1, 8));

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
  document.getElementById("days").innerHTML = days + "d ";
  document.getElementById("hours").innerHTML = hours + "h ";
  document.getElementById("minutes").innerHTML = minutes + "m ";
  document.getElementById("seconds").innerHTML = seconds + "s ";

  // If the count down is over, write some text
  if (distance < 0) {
  clearInterval(x);
  document.getElementById("days").innerHTML = "O";
  document.getElementById("hours").innerHTML = "V";
  document.getElementById("minutes").innerHTML = "E";
  document.getElementById("seconds").innerHTML = "R";
  }
}, 1000);
