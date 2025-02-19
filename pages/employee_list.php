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
          <form action="../employeefunction/create.php" method="POST" onsubmit="return validateForm()">
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
          <form action="../employeefunction/update.php" method="POST">
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
                            <input type="text" class="form-control" name="employee_id" id="idnumber" required>
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
                          <th>ID No.</th>
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Position</th>
                          <th>Office</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      <?php 
                     include '../database/db_connect.php';
                     $result = $conn->query("SELECT * FROM employee");
                     while ($row = $result->fetch_assoc()) {
                         //$formatted_emp_id = sprintf('%03d', $row['employee_id']); // Format employee_id with leading zeros
                         //$middle_initial = !empty($row['midname']) ? strtoupper($row['midname'][0]) . '.' : '';
                         $full_name = "{$row['lname']}, {$row['fname']} {$row['extname']} {$row['midname']}";
                         echo "<tr class='text-center'>";
                         echo "<td>{$row['employee_id']}</td>";
                         echo "<td>{$full_name}</td>";
                         echo "<td>{$row['gender']}</td>";
                         echo "<td>{$row['position']}</td>";
                         echo "<td>{$row['office']}</td>";
                         echo "<td>
                                 <button class='btn btn-success text-white'><i class='fas fa-eye'></i></button>
                                 <button class='btn btn-info' data-toggle='modal' data-target='#editEmployeeModal'
                                   data-employee_id='{$row['employee_id']}'
                                   data-lname='{$row['lname']}'
                                   data-fname='{$row['fname']}'
                                   data-midname='{$row['midname']}'
                                   data-extname='{$row['extname']}'
                                   data-position='{$row['position']}'
                                   data-office='{$row['office']}'
                                   data-gender='{$row['gender']}'>
                                   <i class='fas fa-pencil-alt'></i>
                                 </button>
                                 <button class='btn btn-danger text-white deletebtn' data-employee_id='{$row['employee_id']}'><i class='fas fa-trash-alt'></i></button>
                               </td>";
                         echo "</tr>";
                     }
                     ?>
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

      <!-- Data Alert -->
      <?php include '../includes/data_alert.php'; ?>

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="../vendor/jquery/jquery.min.js"></script>
      <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="../js/ruang-admin.min.js"></script>
      <!-- Page level plugins -->
      <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
      <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

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
              window.location.href = "../auth/logout.php"; // Redirect if confirmed
            }
          });
        });
      </script>

  <script>
     function validateForm() {
       var idnumber = document.getElementById("idnumber").value;
       if (!/^\d+$/.test(idnumber) || Number(idnumber) <= 0) {
         Swal.fire({
           title: 'Invalid ID Number',
           text: 'Please enter a valid integer ID number.',
           icon: 'error',
           confirmButtonText: 'OK'
         });
         return false;
       }
       return true;
     }
   </script>


<script>
     $(document).on('click', '.deletebtn', function(event) {
       event.preventDefault(); // Prevent immediate redirection
       var employee_id = $(this).data('employee_id');

       Swal.fire({
         title: "Are you sure?",
         text: "You will be deleting this data",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#d33",
         cancelButtonColor: "#3085d6",
         confirmButtonText: "Yes, delete!"
       }).then((result) => {
         if (result.isConfirmed) {
           window.location.href = "../employeefunction/delete.php?employee_id=" + employee_id; // Redirect if confirmed
         }
       });
     });
   </script>

   <script>
    $('#editEmployeeModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var employee_id = button.data('employee_id');
      var lname = button.data('lname');
      var fname = button.data('fname');
      var midname = button.data('midname');
      var extname = button.data('extname');
      var position = button.data('position');
      var office = button.data('office');
      var gender = button.data('gender')

      console.log("employee id:", employee_id);

      // Update the modal's content.
      var modal = $(this);
       modal.find('#idnumber').val(employee_id);
       modal.find('#lastName').val(lname);
       modal.find('#firstName').val(fname);
       modal.find('#middleName').val(midname);
       modal.find('#nameExtension').val(extname);
       modal.find('#position').val(position);
       modal.find('#typeOfOffice').val(office);
       modal.find('#typeOfGender').val(gender);
    });
   </script>
</body>

</html>