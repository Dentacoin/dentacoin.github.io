



    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var data = google.visualization.arrayToDataTable([
         ['Dentacoin', '%', { role: 'style' }],
         ['DCN', 10, '#b87333'],            // RGB value

      var options = {
        title: "Density of Precious Metals, in g/cm^3",
        width: 900,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };


// Instantiate and draw our chart, passing in some options.
      var barChart = new google.visualization.BarChart(document.getElementById("progr"));
      barChart.draw(view, options);

}
