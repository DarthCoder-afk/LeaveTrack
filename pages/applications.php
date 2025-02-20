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
  <title>HR Admin - View Leave Applications</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/admin.min.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <style>
    .table-responsive {
      overflow-x: auto;
    }
    .table th, .table td {
      white-space: nowrap;
    }
    .table th {
      text-align: center;
    }
    .table td {
      text-align: center;
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
                            <input type="text" class="form-control" id="firstName" disabled>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" id="middleName" disabled>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Extension</small></label>
                            <input type="text" class="form-control" id="nameExtension" disabled>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Position</label>
                            <input type="text" class="form-control" id="position" disabled>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Office</label>
                            <input type="text" class="form-control" id="office" disabled>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>ID No.</label>
                            <input type="text" class="form-control" id="idnumber" disabled>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group"> 
                            <label>Gender</label>
                            <input type="text" class="form-control" id="gender" disabled>
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
                          <th>Inclusive Dates</th>
                          <th>Day/s</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="text-center">
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
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
      <script src="../js/dataTable.js"></script>
      <script src="../js/logout.js"></script>

</body>

</html>