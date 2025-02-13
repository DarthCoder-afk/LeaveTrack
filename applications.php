<?php
include 'auth.php'; // Ensure authentication

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
  <link href="img/favicon.ico" rel="icon">
  <title>HR Admin - View Leave Applications</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/admin.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php" style="background-color: #2e8517;">
        <div class="sidebar-brand-icon">
          <img src="img/HR.png" style="border-radius: 50%;">
        </div>
        <div class="sidebar-brand-text mx-3">HR Admin</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Features
      </div>
      <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
          aria-expanded="true" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Applications</span>
        </a>
        <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">View</h6>
            <a class="collapse-item" href="applications.php">Leave Applications</a>
            <a class="collapse-item" href="travel_order.php">Travel Orders</a>
            <a class="collapse-item" href="view_calendar.php">Calendar</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
          aria-controls="collapseForm">
          <i class="fab fa-fw fa-wpforms"></i>
          <span>Forms</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Forms</h6>
            <a class="collapse-item" href="#">Leave Form</a>
            <a class="collapse-item" href="#">Travel Form</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="accountsetting.php">
          <i class="fas fa-cog"></i>
          <span>Account Settings</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="logout-link" href="#">
          <i class="fas fa-sign-out-alt"></i>
          <span>Log-out</span>
        </a>
      </li>
      <hr class="sidebar-divider">
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top" style="background-color: #2e8517;">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"
                      aria-label="Search" aria-describedby="basic-addon2" style="border-color: #2e8517;">

                  </div>
                </form>
              </div>
            </li>



            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="#" role="#" data-toggle="#"
                aria-haspopup="false" aria-expanded="false">
                <img class="img-profile rounded-circle" src="img/profile.jpg" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">Administrator</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->


        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Leave Applications</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Leave Application</li>
            </ol>
          </div>

          <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800"></h1>
              <button class="btn btn-primary" data-toggle="modal" data-target="#addApplicationModal">+ ADD</button>
            </div>

            <!-- ADD APPLICATION MODAL -->
            <div class="modal fade" id="addApplicationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document"> <!-- Increased modal width -->
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Add Leave Application</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="addApplicationForm">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" id="lastName" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" id="firstName" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Middle Name <small>(optional)</small></label>
                            <input type="text" class="form-control" id="middleName">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Name Extension <small>(e.g., Jr., Sr., III) (optional)</small></label>
                            <input type="text" class="form-control" id="nameExtension">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Position</label>
                            <input type="text" class="form-control" id="position" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Office</label>
                            <select class="form-control" id="typeOfOffice">
                              <option value="" disabled selected>Select Type of Office</option>
                              <option value="Sangguniang Bayan">Sangguniang Bayan</option>
                              <option value="HRMO">Human Resource Management Office</option>
                              <option value="Office of the Treasury">Office of the Treasury</option>
                              <!-- <option value="Office 4">Office 4</option> -->
                              <!-- <option value="Office 5">Office 5</option> -->
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group"> 
                            <label>Gender</label>
                            <select class="form-control" id="typeOfGender" required>
                              <option value="" disabled selected>Select Type of Gender</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                          <label>Type of Leave</label>
                              <select class="form-control" id="typeOfLeave" required>
                                <option value="" disabled selected>Select Type of Leave</option>
                                <option value="Sick Leave">Sick Leave</option>
                                <option value="Vacation Leave">Vacation Leave</option>
                                <option value="Maternity Leave">Maternity Leave</option>
                                <option value="Paternity Leave">Paternity Leave</option>
                                <option value="Special Privilege Leave">Special Privilege Leave</option>
                                <option value="Solo Parent Leave">Solo Parent Leave</option>
                                <option value="Study Leave">Study Leave</option>
                                <option value="10-Day VAWC Leave">10-Day VAWC Leave</option>
                                <option value="Rehabilitation Leave">Rehabilitation Leave</option>
                                <option value="Special Leave Benefits for Women">Special Leave Benefits for Women</option>
                                <option value="Special Emergency (Calamity) Leave">Others</option>
                                <option value="Adoption Leave">Adoption Leave</option>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Date Applied</label>
                            <input type="date" class="form-control" id="dateApplied" required>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" class="form-control" id="startDate" required onchange=calculateNumberofDays()>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>End Date</label>
                            <input type="date" class="form-control" id="endDate" required onchange=calculateNumberofDays()>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Number of Days</label>
                            <input type="text" class="form-control" id="numberOfDays" disabled>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="formFile" class="form-label">Upload Scanned Document</label>
                            <input type="file" class="form-control" id="formFile">
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-success btn-block">Save</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- Row -->
            <div class="row">
              <!-- DataTable with Hover -->
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="table-responsive p-4">
                    <table class="table align-items-center table-hover" id="dataTableHover">
                      <thead class="thead-light text-center">
                        <tr>
                          <th>Name</th>
                          <th>Position</th>
                          <th>Office</th>
                          <th>Type of Leave</th>
                          <th>Date Applied</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="text-center">
                          <td>John Doe</td>
                          <td>Job Order</td>
                          <td>Treasury Office</td>
                          <td>Sick Leave</td>
                          <td>2025/02/10</td>
                          <td>
                            <button class="btn btn-success"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-info"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!--Row-->


            <!---Container Fluid-->
          </div>


          <!-- Footer -->
          <footer class="sticky-footer bg-white">
            <div class="container my-auto">
              <div class="copyright text-center my-auto">
                <span>copyright &copy; <script>
                    document.write(new Date().getFullYear());
                  </script>
                </span>
              </div>
            </div>
          </footer>
          <!-- Footer -->
        </div>
      </div>

      <!-- Scroll to top -->
      <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
      </a>

      <script>
        function calculateNumberofDays(){
          const startDate = document.getElementById("startDate").value;
          const endDate = document.getElementById("endDate").value;

          if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            const timeDifference = end - start;
            const daysDifference = timeDifference / (1000 * 3600 * 24) + 1;

            if (daysDifference > 0) {
              document.getElementById('numberOfDays').value = daysDifference;
            } else {
              document.getElementById('startDate').value = 0;
              document.getElementById('endDate').value = 0;
              Swal.fire({
                title: "Invalid Dates",
                text: "End date should be greater than start date.",
                icon: "error"
                
              });
            }
          }
        }
      </script>


      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="js/ruang-admin.min.js"></script>
      <!-- Page level plugins -->
      <script src="vendor/datatables/jquery.dataTables.min.js"></script>
      <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

      <!-- Page level custom scripts -->
      <script>
        $(document).ready(function() {
          $('#dataTable').DataTable(); // ID From dataTable 
          $('#dataTableHover').DataTable(); // ID From dataTable with Hover
        });
      </script>
      <script>
        document.getElementById("logout-link").addEventListener("click", function(event) {
          event.preventDefault(); // Prevent immediate redirection

          Swal.fire({
            title: "Are you sure?",
            text: "You will be logged out!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, logout!"
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "logout.php"; // Redirect if confirmed
            }
          });
        });
      </script>

</body>

</html>