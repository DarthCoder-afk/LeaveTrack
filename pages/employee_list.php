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
  <title>HR Admin - Employee List</title>
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
            <h1 class="h3 mb-0 text-gray-800">Employee List</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Employee List</li>
            </ol>
          </div>

          <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800"></h1>
              <button class="btn btn-primary" data-toggle="modal" data-target="#addEmployeeModal">+ ADD</button>
          </div>

          <!-- Add Modal -->
          <form action="../function/employeefunction/create.php" method="POST" onsubmit="return validateForm()">
             <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document"> <!-- Increased modal width -->
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Add Employee Details</h5>
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
                            <input type="text" class="form-control" name="lname" id="lastName" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="fname" id="firstName" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Middle Name <small>(optional)</small></label>
                            <input type="text" class="form-control" name="midname" id="middleName">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Name Extension <small>(e.g., Jr., Sr., III) (optional)</small></label>
                            <input type="text" class="form-control" name="extname" id="nameExtension">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Position</label>
                            <input type="text" class="form-control" name="position" id="position" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Office</label>
                            <select class="form-control" name="office" id="typeOfOffice">
                              <option value="" disabled selected>Select Type of Office</option>
                              <option value="Office of the Municipal Mayor">Office of the Municipal Mayor</option>
                              <option value="Sangguniang Bayan Office">Office of the Sangguniang Bayan</option>
                              <option value="Office of the Municipal Treasurer">Office of the Municipal Treasurer</option>
                              <option value="Office of the Municipal Assessor">Office of the Municipal Assessor</option>
                              <option value="Office of the Municipal Accountant">Office of the Municipal Accountant</option>
                              <option value="Office of the Municipal Budget">Office of the Municipal Budget</option>
                              <option value="Municipal Planning & Development Office">Office of the Municipal Planning & Development Coordinator</option>
                              <option value="Office of the Local Disaster Risk Reduction Management">Office of the Local Disaster Risk Reduction Management</option>
                              <option value="Municipal Agriculture Office">Office of the Municipal Agriculture</option>
                              <option value="Mun. Social Welfare Development Office">Office of the Mun. Social Welfare & Development</option>
                              <option value="Municipal Engineering Office">Municipal Engineering Office</option>
                              <option value="Municipal Health Office">Municipal Health Office</option>
                              <option value="Municipal Civil Registrar">Municipal Civil Registra</option>
                              <option value="General Service Office">General Service Office</option>
                              <option value="Human Resource Management Office">Human Resource Management Office</option>
                              <option value="Municipal Tourism Office">Municipal Tourism Office</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>ID No.</label>
                            <input type="text" class="form-control" name="employee_id" id="idnumber" min ="3" step="1" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group"> 
                            <label>Gender</label>
                            <select class="form-control" name="gender" id="typeOfGender" required>
                              <option value="" disabled selected>Select Type of Gender</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-success btn-block" name="createData">Save</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </form>


          <!-- Update Modal -->
          <form action="../function/employeefunction/update.php" id="editEmployeeForm" method="POST">
             <div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document"> <!-- Increased modal width -->
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Employee Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lname" id="lastName" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="fname" id="firstName" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Middle Name <small>(optional)</small></label>
                            <input type="text" class="form-control" name="midname" id="middleName">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Name Extension <small>(e.g., Jr., Sr., III) (optional)</small></label>
                            <input type="text" class="form-control" name="extname" id="nameExtension">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Position</label>
                            <input type="text" class="form-control" name="position" id="position" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Office</label>
                            <select class="form-control" name="office" id="typeOfOffice">
                              <option value="" disabled selected>Select Type of Office</option>
                              <option value="Office of the Municipal Mayor">Office of the Municipal Mayor</option>
                              <option value="Sangguniang Bayan Office">Office of the Sangguniang Bayan</option>
                              <option value="Office of the Municipal Treasurer">Office of the Municipal Treasurer</option>
                              <option value="Office of the Municipal Assessor">Office of the Municipal Assessor</option>
                              <option value="Office of the Municipal Accountant">Office of the Municipal Accountant</option>
                              <option value="Office of the Municipal Budget">Office of the Municipal Budget</option>
                              <option value="Municipal Planning & Development Office">Office of the Municipal Planning & Development Coordinator</option>
                              <option value="Office of the Local Disaster Risk Reduction Management">Office of the Local Disaster Risk Reduction Management</option>
                              <option value="Municipal Agriculture Office">Office of the Municipal Agriculture</option>
                              <option value="Mun. Social Welfare Development Office">Office of the Mun. Social Welfare & Development</option>
                              <option value="Municipal Engineering Office">Municipal Engineering Office</option>
                              <option value="Municipal Health Office">Municipal Health Office</option>
                              <option value="Municipal Civil Registrar">Municipal Civil Registra</option>
                              <option value="General Service Office">General Service Office</option>
                              <option value="Human Resource Management Office">Human Resource Management Office</option>
                              <option value="Municipal Tourism Office">Municipal Tourism Office</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>ID No.</label>
                            <input type="text" class="form-control" name="employee_id" id="idnumber">
                            <input type="hidden" name="hidden_employee_id" id="hidden_id">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group"> 
                            <label>Gender</label>
                            <select class="form-control" name="gender" id="typeOfGender" required>
                              <option value="" disabled selected>Select Type of Gender</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-success btn-block" name="updateData">Update</button>
                  </div>
                </div>
              </div>
            </div>
          </form>

           

            <!-- Table -->
            <div class="row">
              <!-- DataTable with Hover -->
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="table-responsive p-4">
                    <table class="table align-items-center table-hover" id="dataTableHover">
                      <thead class="thead-light text-center">
                        <tr>
                          <th>ID No.</th>
                          <th>Name</th>
                          <!-- <th>Gender</th> -->
                          <th>Position</th>
                          <th>Office</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php include '../function/employeefunction/fetch.php'?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!--Table-->


            <!---Container Fluid-->
          </div>


        
        </div>
      </div>

      <!-- Scroll to top -->
      <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
      </a>

      <!-- Data Alert -->
      <?php include '../includes/data_alert.php'; ?>


      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="../vendor/jquery/jquery.min.js"></script>
      <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="../js/ruang-admin.min.js"></script>
      <script src="../js/logout.js"></script>
      <script src="../js/employeelist/delete.js"></script>
      <script src="../js/employeelist/update.js"></script>
      <script src="../js/employeelist/validate.js"></script>
      <!-- Page level plugins -->
      <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
      <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

      <!-- Page level custom scripts -->
      <script src="../js/dataTable.js"></script>
      
</body>

</html>