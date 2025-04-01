<?php
include '../auth/auth.php'; // Ensure authentication

//echo "Welcome, " . $_SESSION['username'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../img/favicon.ico" rel="icon">
  <title>HR Admin - Leave Form</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/admin.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

<style>
  .drop-zone {
    border: 2px dashed #03C04A;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    background-color: #f8f9fa;
  }
  .drop-zone.dragover {
    background-color: #e3f2fd;
    border-color: #03C04A;
  }
</style>
</head>

<body id="page-top">
  <div id="wrapper">
        <!-- Sidebar&Topbar -->
        <?php include '../includes/sidebar.php'; ?>
        <!-- Sidebar&Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">History Log</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">History Log</li>
                </ol>
            </div>
          
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="employee-tab" data-toggle="tab" href="#employee" role="tab" aria-controls="employee" aria-selected="true">History</a>
                </li>
            </ul>
            <div class="card shadow mb-4 mt-2">
                <div class="tab-content" id="myTabContent">
                    <!-- Employee Tab -->
                    <div class="tab-pane fade show active" id="employee" role="tabpanel" aria-labelledby="employee-tab">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr class="text-center">
                                            <th>Employee ID</th>
                                            <th>Type</th>
                                            <th>Action Taken</th>
                                            <th>Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include '../function/historyfunction/fetchhistory.php'?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Leave Application Tab -->
                    <div class="tab-pane fade" id="leave" role="tabpanel" aria-labelledby="leave-tab">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>EMP ID</th>
                                            <th>Employee Name</th>
                                            <th>Leave Type</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="#">EMP001</a></td>
                                            <td>John Doe</td>
                                            <td>Sick Leave</td>
                                            <td><span class="badge badge-success">Added</span></td>
                                            <td>03/31/2025 08:30</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Travel Order Tab -->
                    <div class="tab-pane fade" id="travel" role="tabpanel" aria-labelledby="travel-tab">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Travel Order ID</th>
                                            <th>Employee Name</th>
                                            <th>Destination</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="#">T001</a></td>
                                            <td>Michael Brown</td>
                                            <td>New York</td>
                                            <td>5 Days</td>
                                            <td><span class="badge badge-success">Approved</span></td>
                                            <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
     <!-- Clickable Date JS -->
    <script src="calendar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/ruang-admin.min.js"></script>
    <script src="../vendor/chart.js/Chart.min.js"></script>
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/logout.js"></script>

    <!-- JavaScript for Drag & Drop -->
    <script src="../js/draganddrop.js"></script>

</body>

</html>