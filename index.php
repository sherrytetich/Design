<?php
$conn = mysqli_connect("localhost", "root", "", "ussdsecontrial");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT location, SUM(registered) AS total_dependants
        FROM approved
        GROUP BY location";
$result = mysqli_query($conn, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = array($row["location"], (int) $row["total_dependants"]);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <canvas id="myChart"></canvas>
  <script>
    // Replace the data array with the array created above
    var data = <?php echo json_encode($data); ?>;

    // Create an array of colors for the chart
    var colors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];

    // Create an array of labels and an array of data values from the data array
    var labels = [];
    var values = [];
    for (var i = 0; i < data.length; i++) {
      labels.push(data[i][0]);
      values.push(data[i][1]);
    }

    // Create a pie chart with Chart.js
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: labels,
        datasets: [{
          backgroundColor: colors,
          data: values
        }]
      }
    });
  </script>
</body>
</html>
