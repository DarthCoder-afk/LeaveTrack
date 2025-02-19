<?php if (isset($_SESSION['message'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                <?php if ($_SESSION['message'] == "success"): ?>
                    Swal.fire({
                        title: 'Data Saved!',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                <?php elseif ($_SESSION['message'] == "error"): ?>
                    Swal.fire({
                        title: 'Data Not Saved',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                <?php elseif ($_SESSION['message'] == "update"): ?>
                    Swal.fire({
                        title: 'Data Updated!',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                <?php elseif ($_SESSION['message'] == "delete"): ?>
                    Swal.fire({
                        title: 'Data Deleted!',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                <?php endif; ?>
            });
        </script>
    <?php 
        unset($_SESSION['message']); // Clear session message after showing alert
    endif; ?>