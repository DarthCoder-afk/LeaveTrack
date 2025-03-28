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
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="emp-tab" data-toggle="tab" data-target="#emp" type="button" role="tab" aria-controls="employee" aria-selected="true">Employee</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="leave-tab" data-toggle="tab" data-target="#leave" type="button" role="tab" aria-controls="leaveapp" aria-selected="false">Leave Application</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="travel-tab" data-toggle="tab" data-target="#travel" type="button" role="tab" aria-controls="travelord" aria-selected="false">Travel Order</button>
        </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="card mt-3">
                <div class="tab-pane fade show active" id="employee" role="tabpanel" aria-labelledby="emp-tab">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                </tr>
                                <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                                </tr>
                                <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="leaveapplication" role="tabpanel" aria-labelledby="leave-tab">
                <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                </tr>
                                <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                                </tr>
                                <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="travelorder" role="tabpanel" aria-labelledby="travel-tab">

                </div>
            </div>           
        </div>

        

        <!---Container Fluid-->
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