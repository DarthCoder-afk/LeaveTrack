<?php
include '../auth/auth.php'; // Ensure authentication
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="../img/favicon.ico" rel="icon">
  <title>HR Admin - Leave Form</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/admin.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

  <style>
    .section-title {
      background-color: #28a745;
      color: white;
      padding: 10px;
      border-radius: 6px 6px 0 0;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../includes/sidebar.php'; ?>

    <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Leave Form</h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Leave Form</li>
        </ol>
      </div>

      <!-- PDF Viewer Section -->
      <div class="container">
        <div class="card">
          <div class="card-header section-title d-flex justify-content-between align-items-center">
            <span>Leave Form</span>
            <div>
              <button class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#uploadModal">
                <i class="fas fa-upload"></i> Upload File
              </button>
              <button class="btn btn-light btn-sm" type="button" data-toggle="collapse" data-target="#pdfCollapse" aria-expanded="true" aria-controls="pdfCollapse">
                <i class="fas fa-eye"></i> Show/Hide
              </button>
            </div>
          </div>
          <div class="collapse show" id="pdfCollapse">
            <div class="embed-responsive embed-responsive-16by9">
              <?php
              $uploadPath = '../uploads/';
              $files = glob($uploadPath . '*.pdf');
              if (!empty($files)) {
                usort($files, function ($a, $b) {
                  return filemtime($b) - filemtime($a);
                });
                $latestFile = $files[0];
                echo '<embed class="embed-responsive-item" src="' . $latestFile . '" type="application/pdf" width="100%" height="600px">';
              } else {
                echo '<p class="text-center p-4">No leave form uploaded yet.</p>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Upload Modal -->
  <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="uploadModalLabel">Upload Leave Form</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="../function/fileform/upload_leave_form.php" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="modalLeaveFile">Select PDF File:</label>
              <input type="file" class="form-control-file" id="modalLeaveFile" name="leaveFile" accept=".pdf" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Upload</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  <script src="calendar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="../js/demo/chart-area-demo.js"></script>
  <script src="../js/logout.js"></script>
  <script src="../js/draganddrop.js"></script>
</body>

</html>
