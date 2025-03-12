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
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
  

  <style>
    .table-responsive {
      overflow-x: auto;
    }
    .table th, .table td {
      white-space: nowrap;
      text-align: center;
    }
    .inactive-row {
    background-color: #e9ecef !important; /* Light gray */
    color: #6c757d !important; /* Dark gray */
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

          <!-- View Employee Modal -->
          <div class="modal fade" id="viewEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="viewEmployeeLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title"><i class="fas fa-user"></i> Employee Details</h5>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                               
                  <!-- Profile Section -->
                  <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light rounded shadow-sm">
                    <div class="d-flex align-items-center">
                      <img src="../img/default_profile.png" id="profilePic" class="rounded-circle border border-primary" 
                          alt="Profile Picture" width="70" height="70">
                      <div class="ms-3">
                        <h5 id="fullName" class="mb-0 text-primary fw-bold">Anonymous</h5> 
                        <small class="text-muted">ID No: 
                          <span id="profileIdNumber" class="px-2 py-1 fw-bold" 
                                style="color: #fff; background: linear-gradient(45deg, #ff6b6b, #f06595); 
                                      border-radius: 8px; padding: 4px 10px; display: inline-block;">
                            000
                          </span>
                        </small>
                      </div>
                    </div>

                  </div>
                  
                  <!-- Employee Details -->
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Employee ID</label>
                        <input type="text" class="form-control" id="view_employee_id" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control" id="view_status" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" id="view_lname" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" id="view_fname" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" id="view_midname" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name Extension</label>
                        <input type="text" class="form-control" id="view_extname" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Position</label>
                        <input type="text" class="form-control" id="view_position" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Office</label>
                        <input type="text" class="form-control" id="view_office" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Gender</label>
                        <input type="text" class="form-control" id="view_gender" readonly>
                      </div>
                    </div>
                  </div>

                  <!-- Employee Leave & Travel History -->
                  <div class="mt-4">
                      <h5 class="text-primary"><i class="fas fa-history"></i> Leave & Travel History</h5>
                      
                      <!-- Leave History -->
                      <div class="table-responsive">
                          <table class="table table-bordered table-sm">
                              <thead class="bg-light">
                                  <tr>
                                      <th>Leave Type</th>
                                      <th>Start Date</th>
                                      <th>End Date</th>
                                      <th>number of days</th>
                                  </tr>
                              </thead>
                              <tbody id="leaveHistory">
                                  <tr><td colspan="4" class="text-center">No leave history available</td></tr>
                              </tbody>
                          </table>
                      </div>

                      <!-- Travel History -->
                      <div class="table-responsive mt-3">
                          <table class="table table-bordered table-sm">
                              <thead class="bg-light">
                                  <tr>
                                      <th>Purpose</th>
                                      <th>Destination</th>
                                      <th>Start Date</th>
                                      <th>Return</th>
                                  </tr>
                              </thead>
                              <tbody id="travelHistory">
                                  <tr><td colspan="4" class="text-center">No travel history available</td></tr>
                              </tbody>
                          </table>
                      </div>
                  </div>

                  
                </div>
              </div>
            </div>
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
                            <select class="form-control" name="office" id="typeOfOffice" onchange="toggleOfficeInput()" required>
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
                              <option value="Municipal Civil Registrar">Municipal Civil Registrar</option>
                              <option value="General Service Office">General Service Office</option>
                              <option value="Human Resource Management Office">Human Resource Management Office</option>
                              <option value="Municipal Tourism Office">Municipal Tourism Office</option>
                              <option value="optional">Optional</option>
                            </select>
                            <input type="text" class="form-control mt-2" name="custom_office" id="customOffice" placeholder="Enter Office Name" style="display: none;">
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
                        <div class="col-md-8 ">
                          <div class="form-group">
                            <label>Status: </label>
                            <input class="form-control" type='checkbox' data-toggle='toggle' data-width='100' data-onstyle='success' 
                            data-offstyle="danger" data-on='Active' data-off='Inactive' data-size='sm' id="status" name="status">
                            <small><label>(Click to change)</label></small>
                          </div>
                        </div>
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
                            <select class="form-control" name="office" id="editTypeOfOffice" required>
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
                              <option value="Municipal Civil Registrar">Municipal Civil Registrar</option>
                              <option value="General Service Office">General Service Office</option>
                              <option value="Human Resource Management Office">Human Resource Management Office</option>
                              <option value="Municipal Tourism Office">Municipal Tourism Office</option>
                              <option value="optional">Optional</option>
                            </select>
                            <input type="text" class="form-control mt-2" name="custom_office" id="editCustomOfficeInput" placeholder="Enter Office Name" style="display: none;">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label>ID No.</label>
                            <input type="text" class="form-control" name="employee_id" id="idnumber">
                            <input type="hidden" name="hidden_employee_id" id="hidden_id"> 
                            <input type="hidden" name="index_no" id="index_no">
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

            <?php include '../includes/verify_modal.php'?>
            <?php include '../includes/verifymodal2.php'?>


            <!---Container Fluid-->
          </div>


        
        </div>
      </div>

      <!-- ADD JAVASCRIPT can't be found -->
      <script>
      function toggleOfficeInput() {
          var officeDropdown = document.getElementById("typeOfOffice");
          var customOfficeInput = document.getElementById("customOffice");

          if (officeDropdown.value === "optional") {
              customOfficeInput.style.display = "block";
              customOfficeInput.setAttribute("name", "office"); // Change the name so it's submitted
              customOfficeInput.setAttribute("required", "required");
              officeDropdown.removeAttribute("name"); // Prevents submitting the select field
          } else {
              customOfficeInput.style.display = "none";
              customOfficeInput.removeAttribute("required");
              customOfficeInput.removeAttribute("name");
              officeDropdown.setAttribute("name", "office");
          }
      }
      </script>



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
      <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
      

      <!-- Page level custom scripts -->
      <script src="../js/dataTable.js"></script>
      <script src="../js/employeelist/view.js"></script>

      
</body>

</html>