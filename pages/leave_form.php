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
            <h1 class="h3 mb-0 text-gray-800">Leave Form</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Leave Form</li>
            </ol>
          </div>

          <!-- <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800"></h1>
              <div class="ms-auto">
                <button class="btn btn-primary" data-toggle="modal" data-target="#leavemodal">
                  <i class="fas fa-file-alt"></i> Upload Leave Form
                </button>
              </div>
            </div>
          </div>

          <form action="../function/details/upload_leaveform.php" method="POST" enctype="multipart/form-data">
            <div class="modal fade" id="leavemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document"> 
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Leave Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="leave_form">Upload Leave Form (PDF):</label>

                    
                        <div id="drop-zone" class="drop-zone mb-3">
                          <p id="filename">Drag & Drop your file here or click to browse</p>
                          <input type="file" name="leave_form" id="leave_form" accept=".pdf" hidden>
                        </div>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-block" name="upload">Save</button>
                  </div>
                </div>
              </div>
            </div>
          </form> -->
    

          <!-- Pdf Form -->
          <div class="container">
            <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="embed-responsive embed-responsive-16by9">
                   <embed class="embed-resposive-item" src="../forms/leave_form.pdf">
                  </div>
                </div> 
            </div>       
          </div>
          <!-- Pdf Form -->

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