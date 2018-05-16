
<script src="../static/vendor/jquery/jquery.min.js"></script>

<script src="../static/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../static/vendor/metisMenu/metisMenu.min.js"></script>
<script src="../static/vendor/raphael/raphael.min.js"></script>
<script src="../static/vendor/morrisjs/morris.min.js"></script>
<script src="../static/data/morris-data.js"></script>
<script src="../static/dist/js/sb-admin-2.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Sales', 'Expenses'],
          {% for data in datas %}
            ['{{data.date}}',  {{data.sales}}, {{data.expenses}}],
          {% endfor %}
        ]);
        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };
        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

</body>

</html>