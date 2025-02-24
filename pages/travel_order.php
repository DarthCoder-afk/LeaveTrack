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
  <title>HR Admin - View Travel Orders</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/admin.min.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <style>
     .table {
      width: 100%;
      table-layout: auto;
    }

    .table th, .table td {
      white-space: nowrap;
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
            <h1 class="h3 mb-0 text-gray-800">Travel Order Applications</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Travel Order</li>
            </ol>
          </div>

          <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800"></h1>
              <button class="btn btn-primary" data-toggle="modal" data-target="#addApplicationModal">+ ADD</button>
            </div>

            <!-- ADD APPLICATION MODAL -->
             <form action="../function/travelfunctions/addtravel.php" id="addApplicationForm" method="POST" enctype="multipart/form-data">
                <div class="modal fade" id="addApplicationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document"> <!-- Increased modal width -->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Add Travel Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="addApplicationForm">
                          <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label>ID No.</label>
                                <input type="text" class="form-control" name="employee_Id" id="idnumber" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lname" id="lastName" disabled>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname" id="firstName" disabled>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="midname" id="middleName" disabled>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Extension</small></label>
                                <input type="text" class="form-control" name="extname" id="nameExtension" disabled>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Position</label>
                                <input type="text" class="form-control" name="position" id="position" disabled>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Office</label>
                                <input type="text" class="form-control" name="office" id="office" disabled>
                              </div>
                            </div>
                            <!--  -->
                            <input type="hidden" name="gender" id="gender">
                            <!--  -->
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Purpose</label>
                                <input type="text" class="form-control" name="pur" id="purpose" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Destination</label>
                                <input type="text" class="form-control" name="des" id="destination" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Date Applied</label>
                                <input type="date" class="form-control" name="datefiled" id="dateApplied" required>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="sdate" id="startDate" required onchange=calculateNumberofDays()>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label>End Date</label>
                                <input type="date" class="form-control" name="edate" id="endDate" required onchange=calculateNumberofDays()>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Number of Days</label>
                                <input type="number" class="form-control" name="days" id="numberOfDays" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="formFile" class="form-label">Upload Scanned Document</label>
                                <input type="file" class="form-control" name="form" id="formFile">
                              </div>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-success btn-block" name="AddTravel">Save</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
             </form>
            
             
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
                          <th>Purpose</th>
                          <th>Destination</th>        
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                       
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!--Row-->

            <?php include '../includes/data_alert.php'; ?>

            <!---Container Fluid-->
          </div>

        </div>
      </div>

      <!-- Scroll to top -->
      <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
      </a>

      <script src="../js/datechecker.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="../vendor/jquery/jquery.min.js"></script>
      <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="../js/ruang-admin.min.js"></script>

      <!-- Page level plugins -->
      <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
      <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

      <!-- Page level custom scripts -->
      <script src="../js/datechecker.js"></script>
      <script src="../js/dataTable.js"></script>
      <script src="../js/logout.js"></script>
      <script src="../js/employeeDetails.js"></script>
</body>

</html>