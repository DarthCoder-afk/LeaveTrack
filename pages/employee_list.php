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

            <!-- ADD APPLICATION MODAL -->
            <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document"> <!-- Increased modal width -->
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Add Employee</h5>
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
                              <option value="Mayor's Office">Mayor's Office (MO)</option>
                              <option value="Human Resource Management Office">Human Resource Management Office (HRMO)</option>
                              <option value="Municipal Planning & Development Office">Municipal Planning & Development Office (MPDO)</option>
                              <option value="Municipal Civil Registrar">Municipal Civil Registrar (MCR)</option>
                              <option value="Municipal Treasurer's Office">Municipal Treasurer's Office (MTO)</option>
                              <option value="General Service Office">General Service Office (GSO)</option>
                              <option value="Municipal Accounting Office">Municipal Accounting Office (MAO)</option>
                              <option value="Municipal Assessor's Office">Municipal Assessor's Office</option>
                              <option value="Sangguniang Bayan Office">Sangguniang Bayan Office (SBO)</option>
                              <option value="Mun. Social Welfare Development Office">Mun. Social Welfare Development Office (MSWDO)</option>
                              <option value="Municipal Agriculture Office">Municipal Agriculture Office (MAO)</option>
                              <option value="Municipal Engineering Office">Municipal Engineering Office (MEO)</option>
                              <option value="Municipal Tourism Office">Municipal Tourism Office (MTO)</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>ID No.</label>
                            <input type="text" class="form-control" id="middleName">
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
                          <th>ID No.</th>
                          <th>Name</th>
                          <th>Position</th>
                          <th>Office</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="text-center">
                          <td>023</td>
                          <td>John Doe</td>
                          <td>Job Order</td>
                          <td>Municipal Accounting Office</td>
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

</body>

</html>