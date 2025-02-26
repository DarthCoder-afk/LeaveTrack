<?php
include '../auth/auth.php'; // Ensure authentication

//echo "Welcome, " . $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>HR Admin - View Calendar</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/admin.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../function/dashboard/calendar/calendar_data.php'; ?>
    <!-- Sidebar & Topbar -->
    <?php include '../includes/sidebar.php'; ?>
    <!-- End of Sidebar & Topbar -->

    <!-- Container Fluid -->
    <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Calendar</h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Calendar</li>
        </ol>
      </div>

      <!-- Calendar Card -->
      <div class="container">
        <div class="card">
          <div class="card-header bg-success text-white">
            <h2 class="text-center mb-4 mt-3">Leave & Travel Calendar</h2>
          </div>
          <div class="card-body">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
      <!-- End Calendar Card -->
    </div>
    <!-- End Container Fluid -->
  </div>

  <!-- Modal for Showing Applicants -->
  <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalLabel">Events on this Day</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul id="eventList" class="list-group"></ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- End Wrapper -->

  <!-- Scroll to Top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- FullCalendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  <!-- jQuery and Bootstrap -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Admin Scripts -->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
  
  <!-- Custom Calendar JS -->
  <script>
    var eventsData = <?php echo $events_json; ?>;
  </script>
  <!-- jQuery and Bootstrap JS (Put This BEFORE Your Scripts) -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- FullCalendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

  <!-- Load events and calendar scripts -->
  <script>
      var eventsData = <?php echo $events_json; ?>;
  </script>
  <script src="../js/calendar.js"></script>

</body>
</html>
