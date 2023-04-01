<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dependants by Location</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body{
      background-color: #aecdc2;
    }
    canvas {
      display: block;
      margin: 0 auto;
      background-color: #aecdc2;
      margin-top: 30px;
    }
  </style>
</head>
<body>
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

    $colors = ['#004c6d','#006d90','#008fb1','#00b3cf','#00d9e9','#00ffff'];
  ?>
  <canvas id="myChart" width="600" height="600"></canvas>
  
  </div>
  <script>
    var data = <?php echo json_encode($data); ?>;
    var colors = <?php echo json_encode($colors); ?>;
    var labels = [];
    var values = [];
    for (var i = 0; i < data.length; i++) {
      labels.push(data[i][0]);
      values.push(data[i][1]);
    }
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: labels,
        datasets: [{
          backgroundColor: colors,
          data: values
        }]
      },
      options: {
        responsive: false,
        maintainAspectRatio: false
      }
    });
  </script>
</body>
</html>
