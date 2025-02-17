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
  <title>HR Admin - Dashboard</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html" style="background-color: #2e8517;">
        <div class="sidebar-brand-icon">
          <img src="img/HR.png" style="border-radius: 50%;">
        </div>
        <div class="sidebar-brand-text mx-3">HR Admin</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Features
      </div>
      <li class="nav-item">
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
      <a class="nav-link" href="leave_form.php">
          <i class="fas fa-print"></i>
          <span>Leave Form</span>
        </a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="employee_list.php">
          <i class="fas fa-users"></i>
          <span>Employee List</span>
        </a>
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
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Applied Leaves this Month</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                        <span>Since last month</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Travel Orders this Month</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                        <span>Since last years</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-shuttle-van fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Applied Monetizations</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>
                        <span>Since last month</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-check-alt fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            
            <div class="col-xl-8 col-lg-12 mb-4">
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-dark">Recently Applied Leaves</h6>
                  <a class="m-0 float-right btn btn-danger btn-sm" href="applications.php">View More <i
                      class="fas fa-chevron-right"></i></a>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Leave Type</th>
                        <th>Applied Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>Sick Leave</td>
                        <td>2025/02/11</td>
                        <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>

            <div class="col-xl-4 col-lg-5 ">
              <div class="card">
                <div class="card-header py-4 bg-success d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 text-light">Travel Orders</h6>
                </div>
                <div>
                  <div class="customer-message align-items-center">
                    <a class="font-weight-bold" href="#">
                      <div class="text-truncate message-title text-dark">Scenal Meeting</div>
                      <div class="small text-gray-500 message-time font-weight-bold">John Doe · 2025/02/15  </div>
                    </a>
                  </div>
                  <div class="card-footer text-center">
                    <a class="m-0 small text-success card-link" href="travel_order.php">View More <i
                        class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          </div>
         

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
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