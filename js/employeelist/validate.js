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
