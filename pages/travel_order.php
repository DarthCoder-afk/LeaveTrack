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
                                <input type="number" class="form-control" name="days" id="numberOfDays" readonly>
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
                      </div>
                    </div>
                  </div>
                </div>
             </form>

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
                                <input type="text" class="form-control" name="employee_Id" id="idnumber" required>
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
                                <input type="number" class="form-control" name="days" id="numberOfDays" readonly>
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
                          <button type="submit" class="btn btn-success btn-block" name="EditTravel">Save</button>
                       
                      </div>
                    </div>
                  </div>
                </div>
             </form>

              <!-- VIEW LEAVE MODAL (Improved) -->
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
                                              <label>Purpose</label>
                                              <input type="text" class="form-control" id="viewPurpose" disabled>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Destination </label>
                                              <input type="text" class="form-control" id="viewDestination" disabled>
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
                          <th>Destination</th>        
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
      <script src="../js/filelabel.js"></script>
      <script src="../js/dataTable.js"></script>
      <script src="../js/logout.js"></script>
      <script src="../js/employeeDetails.js"></script>
      <script src="../js/travelapplication/updatetravel.js"></script>
      <script src="../js/travelapplication/deletetravel.js"></script>
      <script src="../js/travelapplication/viewtravel.js"></script>
</body>

</html>