<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';


$query = "SELECT * FROM tblattendance WHERE admissionNo = '$_SESSION[admissionNumber]'";
$rs = $conn->query($query);

if (!$rs) {
   
    echo "Error: " . $conn->error;
    exit(); 
    echo $query;

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>Dashboard</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include "Includes/sidebar.php";?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php include "Includes/topbar.php";?>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Calendar Filter -->
            <div class="col-md-6">
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="datepicker" placeholder="Select Date">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button">Filter</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Attendance Table -->
          <div class="row">
            <div class="col-md-12">
              <table class="table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

              
                  // Loop through the attendance data and display it in the table rows
                  while ($row = $rs->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['dateTimeTaken'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <!---Container Fluid-->
        </div>
        <!-- Footer -->
        <?php include 'includes/footer.php';?>
        <!-- Footer -->
      </div>
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Scripts -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>
