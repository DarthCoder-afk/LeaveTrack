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
            <h1 class="h3 mb-0 text-gray-800">Leave Applications</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Leave Application</li>
            </ol>
          </div>

          <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800"></h1>
              <div class="ms-auto">
                <button class="btn btn-success" data-toggle="modal" data-target="#reportModal">
                  <i class="fas fa-file-alt"></i> Generate Report
                </button>

                <button class="btn btn-primary" data-toggle="modal" data-target="#addApplicationModal">
                  <i class="fas fa-plus"></i> ADD
                </button>
              </div>
            </div>
          </div>

            <!-- ADD APPLICATION MODAL -->
            <form action="../function/leavefunctions/addleave.php" id="addApplicationForm" method="POST" enctype="multipart/form-data">
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
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>ID No.</label>
                            <input type="text" class="form-control" name="employee_Id" id="idnumber" required>
                            <input type="hidden" name="emp_index" id="emp_index">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastName" disabled>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstName" disabled>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" name="middlename" id="middleName" disabled>
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
                        <div class="col-md-6">
                          <div class="form-group"> 
                            <label>Gender</label>
                            <input type="text" class="form-control"name="gender" id="gender" disabled>
                            <input type="hidden" name="hidden_gender" id="hidden_gender">
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Type of Leave</label>
                            <select class="form-control" name="leavetype" id="typeOfLeave" required>
                              <option value="" disabled selected>Select Type of Leave</option>
                            </select>
                          </div>
                        </div>

                        <!-- Hidden input field for optional leave type -->
                        <div class="col-md-6" id="optionalLeaveContainer" style="display: none;">
                          <div class="form-group">
                            <label>Specify Leave Type</label>
                            <input type="text" class="form-control" name="optional_leavetype" id="optionalLeaveInput" placeholder="Enter Leave Type">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Date Applied</label>
                            <input type="date" class="form-control" name="applieddate" id="dateApplied" required onchange=calculateNumberofDays()>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" class="form-control" name="startdate" id="startDate" disabled  onchange=calculateNumberofDays()>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>End Date</label>
                            <input type="date" class="form-control" name="enddate" id="endDate" disabled onchange=calculateNumberofDays()>
                          </div>
                        </div>
                        
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Number of Days</label>
                            <div class="input-group">
                              <input type="text" class="form-control" name="numdays" id="numberOfDays" readonly>
                              <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" id="toggleHolidayInput">
                                  <i class="fas fa-minus-circle"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Hidden input for subtracting holidays -->
                        <div class="col-md-3" id="holidayContainer" style="display: none;">
                          <div class="form-group">
                            <label>Minus Holidays</label>
                            <input type="number" class="form-control" name="holidayDeduction" id="holidayDeduction" min="0" value="0" oninput="calculateNumberofDays()">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                          <label>Upload File <small>(optional)</small></label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" name="form" id="formFile">
                              <label class="custom-file-label" for="customFile" id="formLabel">Choose file</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-success btn-block" name="AddLeave">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>

            <!-- VIEW LEAVE MODAL (Improved) -->
            <div class="modal fade" id="viewLeaveModal" tabindex="-1" role="dialog" aria-labelledby="viewLeaveLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title"><i class="fas fa-user"></i> View Leave Application</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Profile Section -->
                            <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light rounded shadow-sm">
                                <div class="d-flex align-items-center">
                                    <img src="../img/default_profile.png" id="profilePic" class="rounded-circle border border-primary" 
                                        alt="Profile" width="70" height="70">
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

                                <!-- File Button -->
                                <a id="view_file_btn" href="#" target="_blank" class="btn btn-sm btn-primary d-none">
                                    <i class="fas fa-file-alt"></i> View Document
                                </a>
                            </div>


                                <!-- Leave Details -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" id="viewLastName" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" id="viewFirstName" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Position</label>
                                            <input type="text" class="form-control" id="viewPosition" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Office</label>
                                            <input type="text" class="form-control" id="viewOffice" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Type of Leave</label>
                                            <input type="text" class="form-control" id="viewTypeOfLeave" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date Applied</label>
                                            <input type="date" class="form-control" id="viewDateApplied" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" class="form-control" id="viewStartDate" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" class="form-control" id="viewEndDate" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Number of Days</label>
                                            <input type="text" class="form-control" id="viewNumberOfDays" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            
            </form>
            
            <!-- EDIT APPLICATION MODAL -->
            
            <form action="../function/leavefunctions/updateleave.php" method="POST" enctype="multipart/form-data">
              <div class="modal fade" id="editLeaveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document"> <!-- Increased modal width -->
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Update Leave Application</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>ID No.</label>
                                <input type="text" class="form-control" name="employee_Id" id="idnumber" required>
                                <input type="hidden" name="index_no" id="index_no">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="lastName" disabled>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="firstname" id="firstName" disabled>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="middlename" id="middleName" disabled>
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
                            <div class="col-md-6">
                              <div class="form-group"> 
                                <label>Gender</label>
                                <input type="text" class="form-control" name="gender" id="gender" disabled>
                                <input type="hidden" name="hidden_gender" id="hidden_gender">
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Type of Leave</label>
                                <select class="form-control" name="leavetype" id="typeOfLeave" required>
                                  <option value="" disabled selected>Select Type of Leave</option>
                                  <option value="Optional">Optional</option>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-6" id="optionalLeaveDiv" style="display: none;">
                              <div class="form-group">
                                <label>Specify Leave Type</label>
                                <input type="text" class="form-control" name="optionalLeaveType" id="optionalLeaveType">
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Date Applied</label>
                                <input type="date" class="form-control" name="applieddate" id="dateApplied" required>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="startdate" id="startDate2" required onchange=UpdatecalculateNumberofDays()>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label>End Date</label>
                                <input type="date" class="form-control" name="enddate" id="endDate2" required onchange=UpdatecalculateNumberofDays()>
                              </div>
                            </div>
                            <div class="col-md-3">
                          <div class="form-group">
                            <label>Number of Days</label>
                            <div class="input-group">
                              <input type="text" class="form-control" name="numdays" id="numberOfDays2" readonly>
                              <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" id="updatetoggleHolidayInput">
                                  <i class="fas fa-minus-circle"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>

                          <!-- Hidden input for subtracting holidays -->
                          <div class="col-md-3" id="updateholidayContainer" style="display: none;">
                            <div class="form-group">
                              <label>Minus Holidays</label>
                              <input type="number" class="form-control" name="holidayDeduction" id="updateholidayDeduction" min="0" value="0" oninput="calculateNumberofDays()">
                            </div>
                          </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Upload File <small>(optional)</small></label>
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" name="form" id="updateFile">
                                  <label class="custom-file-label" for="customFile" id="updateLabel">Choose file</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-success btn-block" name="UpdateLeave">Save</button>
                      </div>
                  </div>
                </div>
              </div>
            </form>

            <!-- Report Modal -->
            <div class="modal fade" id="reportModal" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-lg" role="document"> <!-- Increased width -->
                <div class="modal-content">
                  
                  <!-- Modal Header -->
                  <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-file-alt"></i> Generate Leave Applications Report</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal Body -->
                  <div class="modal-body">
                    <form id="reportForm">
                      <div class="row">
                        <div class="col-md-6">
                          <label><i class="fas fa-calendar-alt"></i> Start Date:</label>
                          <input type="date" id="reportStartDate" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                          <label><i class="fas fa-calendar-alt"></i> End Date:</label>
                          <input type="date" id="reportEndDate" class="form-control" required>
                        </div>
                      </div>
                      <div class="text-center mt-3">
                        <small class="text-muted">Select a date range to generate the leave applications report.</small>
                      </div>
                    </form>
                  </div>

                  <!-- Modal Footer -->
                  <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                      <i class="fas fa-times"></i> Close
                    </button>
                    <button type="button" id="generateReportBtn" class="btn btn-success">
                      <i class="fas fa-file-pdf"></i> Generate Report
                    </button>
                  </div>

                </div>
              </div>
            </div>


            <!-- Leave Application Table -->
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
                          <!-- <th>Position</th> -->
                          <!-- <th>Office</th> -->
                          <th>Leave Type</th>
                          <th>Date Applied</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Table Data -->
                        <?php include '../function/leavefunctions/fetchleave.php'; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!--Row-->

            <!-- Data Alert -->
            <?php include '../includes/data_alert.php'; ?>
            <?php include '../includes/verify_modal.php'?>

            <!-- Test Pull Request -->

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
      <script src="../js/leaveapplication/generateReport.js"></script>
      

      <!-- Page level plugins -->
      <script src="../js/filelabel.js"></script>
      <script src="../js/employeeDetails.js"></script>
      <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
      <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
      <script src="../js/leaveapplication/deleteleave.js"></script>
      <script src="../js/leaveapplication/updateleave.js"></script>
      <script src="../js/dataTable.js"></script>
      <script src="../js/logout.js"></script>
      <script src="../js/leaveapplication/viewleave.js"></script>

</body>

</html>