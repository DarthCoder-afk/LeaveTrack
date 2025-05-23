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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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
                          <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label>ID No.</label>
                                <input type="text" class="form-control" name="employee_Id" id="idnumber" required>
                                <input type="hidden" name="emp_index"  id="emp_index">
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
                                <input type="hidden" class="form-control" name="position2" id="position2">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Office</label>
                                <input type="text" class="form-control" name="office" id="office" disabled>
                              </div>
                            </div>
                        
                            <input type="hidden" class="form-control"name="gender" id="gender" disabled>
                            <input type="hidden" name="hidden_gender" id="hidden_gender">
                          
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
                                <label>Date of Filing</label>
                                <input type="date" class="form-control" name="datefiled" id="dateApplied" onchange=calculateNumberofDays()>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Leave Date Type</label>
                                <div>
                                  <label class="mr-2">
                                    <input type="radio" name="date_type" value="specific" checked onchange="toggleDateType()"> Specific Dates
                                  </label>
                                  <label >
                                    <input type="radio" name="date_type" value="consecutive" onchange="toggleDateType()"> Consecutive Dates
                                  </label>
                                  
                                </div>
                              </div>
                            </div>
                            
                            <!-- Consecutive Dates -->
                            <div class="row ml-3" id="consecutiveDatesContainer" style="display: none;">
                              <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="startdate" id="startDate"  onchange="calculateNumberofDays()">
                              </div>
                              <div class="form-group ml-4">
                                <label>End Date</label>
                                <input type="date" class="form-control" name="enddate" id="endDate"  onchange="calculateNumberofDays()">
                              </div>
                              <div class="form-group ml-4">
                                <label>Number of Days</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" name="numdays" id="numberOfDays" step="0.5" min="0">
                                  <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="toggleHolidayInput">
                                      <i class="fas fa-minus-circle"></i>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row ml-1" id="specificDatesContainer">
                              <!-- Specific Dates Input -->
                              <div class="form-group col-md-6">
                                <label>Inclusive Date/s</label>
                                <input type="text" class="form-control" name="specific_dates" id="specificDates" placeholder="Select dates">
                                <small class="form-text text-muted">Click to select multiple dates or one.</small>
                              </div>

                              <!-- Number of Days Input -->
                              <div class="form-group col-md-6">
                                <label>Number of Days</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" name="specificnumdays" id="specificnumdays" step="0.5" min="0">
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
                                  <label class="custom-file-label" for="customFile" id="fileLabel">Choose file</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-success btn-block" name="AddTravel">Save</button>
                          <small><a href="" class="mt-3" data-toggle="modal" data-target="#viewEmployeeModal">Having trouble finding an employee?</a></small>
                      </div>
                    </div>
                  </div>
                </div>
            </form>

              <!-- Employee List -->
            <?php include '../function/historyfunction/fetchemployee.php'?>

              <!-- EDIT APPLICATION MODAL -->
              <form action="../function/travelfunctions/updatetravel.php" id="addApplicationForm" method="POST" enctype="multipart/form-data">
                <div class="modal fade" id="EditTravelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document"> <!-- Increased modal width -->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Add Travel Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                   
                          <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label>ID No.</label>
                                <input type="text" class="form-control" name="employee_Id" id="idnumber" readonly>
                                <input type="hidden" class="form-control" name="index_no" id="index_no" required>
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
                            
                            <input type="hidden" name="gender" id="gender"> 
                           
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Purpose</label>
                                <input type="text" class="form-control" name="purpose" id="purpose" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Destination</label>
                                <input type="text" class="form-control" name="destination" id="destination" required>
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
                                <label>Date of Filing</label>
                                <input type="date" class="form-control" name="applieddate" id="dateApplied2"  onchange="UpdatecalculateNumberofDays()">
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Leave Date Type</label>
                                <div>
                                  <label class="mr-2">
                                    <input type="radio" name="date_type2" value="specific" checked onchange="toggleDateType2()"> Specific Dates
                                  </label>
                                  <label>
                                    <input type="radio" name="date_type2" value="consecutive" onchange="toggleDateType2()"> Consecutive Dates
                                  </label>
                                </div>
                              </div>
                            </div>
                            
                            <!-- Consecutive Dates -->
                            <div class="row ml-3" id="consecutiveDatesContainer2" style="display: none;">
                              <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="startdate" id="startDate2" onchange="UpdatecalculateNumberofDays()">
                              </div>
                              <div class="form-group ml-4">
                                <label>End Date</label>
                                <input type="date" class="form-control" name="enddate" id="endDate2" onchange="UpdatecalculateNumberofDays()">
                              </div>
                              <div class="form-group ml-4">
                                <label>Number of Days</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" name="numdays" id="numberOfDays2" step="0.5" min="0">
                                  <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="toggleHolidayInput">
                                      <i class="fas fa-minus-circle"></i>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Specific Dates -->
                            <div class="row" id="specificDatesContainer2" >
                              <div class="form-group col-md-6 ml-3">
                                <label>Inclusive Date/s</label>
                                <input type="text" class="form-control" name="specific_dates" id="specificDates2" placeholder="Select dates">
                                <small class="form-text text-muted">Click to select multiple dates or one.</small>
                              </div>

                              <div class="form-group col-md-4">
                                <label>Number of Days</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" name="specificnumdays2" id="specificnumdays2"  step="0.5" min="0">
                                  <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="toggleHolidayInput">
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
                          <button type="submit" class="btn btn-success btn-block" name="EditTravel">Save Changes</button>
                       
                      </div>
                    </div>
                  </div>
                </div>
             </form>

              <!-- VIEW TRAVEL MODAL -->
              <form>
                <div class="modal fade" id="ViewTravelModal" tabindex="-1" role="dialog" aria-labelledby="viewTravelLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="fas fa-user"></i> View Travel Application</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <div class="modal-body">
                        <!-- Profile Section -->
                        <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light rounded shadow-sm">
                          <div class="d-flex align-items-center">
                            <img src="../img/default_profile.png" id="profilePic" class="rounded-circle border border-primary" alt="Profile" width="70" height="70">
                            <div class="ms-3">
                              <h5 id="fullName" class="mb-0 text-primary fw-bold">Anonymous</h5>
                              <small class="text-muted">ID No:
                                <span id="profileIdNumber" class="px-2 py-1 fw-bold" style="color: #fff; background: linear-gradient(45deg, #ff6b6b, #f06595); border-radius: 8px; padding: 4px 10px; display: inline-block;">
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

                        <!-- Travel Details -->
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
                              <label>Purpose</label>
                              <input type="text" class="form-control" id="viewPurpose" disabled>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Destination</label>
                              <input type="text" class="form-control" id="viewDestination" disabled>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Date of Filing</label>
                              <input type="text" id="viewDateApplied" class="form-control" disabled>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Number of Days</label>
                              <input type="text" class="form-control" id="viewNumberOfDays" disabled>
                            </div>
                          </div>

                          <!-- Consecutive Dates Group -->
                          <div class="col-md-6 d-none" id="consecutiveDatesGroup">
                            <div class="form-group">
                              <label>Start Date</label>
                              <input type="text" id="viewStartDate" class="form-control" disabled>
                            </div>
                          </div>
                          <div class="col-md-6 d-none" id="consecutiveDatesGroupEnd">
                            <div class="form-group">
                              <label>End Date</label>
                              <input type="text" id="viewEndDate" class="form-control" disabled>
                            </div>
                          </div>

                          <!-- Specific Dates Group -->
                          <div id="specificDatesGroup" class="col-md-12 d-none">
                              <div class="form-group">
                                  <label>Specific Dates</label>
                                  <textarea class="form-control" id="viewSpecificDates" rows="4" readonly></textarea>
                              </div>
                          </div>
                        </div> <!-- End .row -->
                      </div> <!-- End .modal-body -->
                    </div> <!-- End .modal-content -->
                  </div>
                </div>
              </form>




            <!-- Report Modal -->
            <div class="modal fade" id="reportModal" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-lg" role="document"> <!-- Increased width -->
                <div class="modal-content">
                  
                  <!-- Modal Header -->
                  <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-file-alt"></i> Generate Travel Report</h5>
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
                      <!-- Add the "All Reports" checkbox -->
                      <div class="row mb-3">
                        <div class="col-md-12">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="generateAllReports">
                            <label class="form-check-label" for="generateAllReports">
                              <i class="fas fa-file-alt"></i> Generate All Reports (ignores date range)
                            </label>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>

                  <!-- Toggle Button -->
                  <div class="text-center mb-3">
                    <button class="btn btn-outline-secondary btn-sm" type="button" data-toggle="collapse" data-target="#settingsSection" aria-expanded="false" aria-controls="settingsSection">
                      <i class="fas fa-sliders-h"></i> Edit Municipality / Province / Logo
                    </button>
                  </div>

                  <!-- Collapsible Section -->
                  <div class="collapse" id="settingsSection">
                    <div class="card card-body border border-secondary">
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label><i class="fas fa-city"></i> Municipality Name:</label>
                          <input type="text" name="municipality_name" id="municipalityName" class="form-control" placeholder="e.g. Talisay">
                        </div>

                        <div class="col-md-6 mb-3">
                          <label><i class="fas fa-map-marker-alt"></i> Province Name:</label>
                          <input type="text" name="province_name" id="provinceName" class="form-control" placeholder="e.g. Camarines Norte">
                        </div>

                        <div class="col-md-6 mb-3">
                          <label><i class="fas fa-image"></i> Logo:</label>
                          <input type="file" name="logo_file" id="logoFile" accept="image/*" class="form-control">
                        </div>
                      </div>
                    </div>
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


              
            <!-- Row -->
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
                          <th>Position</th>
                          <th>Purpose</th>
                          <th>Date of Filing</th>        
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php include '../function/travelfunctions/fetchtravel.php'?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!--Row-->

            <?php include '../includes/data_alert.php'; ?>
            <?php include '../includes/verify_modal.php'; ?>
            <?php include '../includes/verifymodal2.php'; ?>

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
      <script src="../js/leaveapplication/generateReportTravel.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

      <!-- Page level plugins -->
      <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
      <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

      <!-- Page level custom scripts -->
      <script src="../js/filelabel.js"></script>
      <script src="../js/dataTable.js"></script>
      <script src="../js/logout.js"></script>
      <script src="../js/employeeDetails.js"></script>
      <script src="../js/travelapplication/updatetravel.js"></script>
      <script src="../js/travelapplication/deletetravel.js"></script>
      <script src="../js/travelapplication/viewtravel.js"></script>
</body>

</html>