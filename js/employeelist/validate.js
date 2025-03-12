document.addEventListener('DOMContentLoaded', function() {
  var idnumber = document.getElementById("idnumber");
  var lname = document.getElementById("lastName");
  var fname = document.getElementById("firstName");
  var mname = document.getElementById("middleName");
  var pos = document.getElementById("position");

  idnumber.addEventListener('input', function() {
      validateField(idnumber, /^\d+$/, "Invalid ID Number");
  });

  lname.addEventListener('input', function() {
      validateField(lname, /^[a-zA-Z\s\-]+$/, "Please input proper last name");
  });

  fname.addEventListener('input', function() {
      validateField(fname, /^[a-zA-Z\s\-]+$/, "Please input proper first name");
  });

  mname.addEventListener('input', function() {
      validateField(mname, /^[a-zA-Z\s\-]+$/, "Please input proper middle name");
  });

  pos.addEventListener('input', function() {
      validateField(pos, /^[a-zA-Z\s\-]+$/, "Please input proper position");
  });
});

function validateForm() {
  var idnumber = document.getElementById("idnumber");
  var lname = document.getElementById("lastName");
  var fname = document.getElementById("firstName");
  var mname = document.getElementById("middleName");
  var pos = document.getElementById("position");
  var isValid = true;

  // Reset previous validation styles and messages
  resetValidation(idnumber);
  resetValidation(lname);
  resetValidation(fname);
  resetValidation(mname);
  resetValidation(pos);

  if (!/^\d+$/.test(idnumber.value) || Number(idnumber.value) <= 0) {
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'Please input valid data. Try again'
    });
      isValid = false;
  }

  if (!/^[a-zA-Z\s\-]+$/.test(lname.value)) {
    Swal.fire({
      icon: 'error',
      title: 'Error!',
      text: 'Please input valid data. Try again'
  });
      isValid = false;
  }

  if (!/^[a-zA-Z\s\-]+$/.test(fname.value)) {
    Swal.fire({
      icon: 'error',
      title: 'Error!',
      text: 'Please input valid data. Try again'
  });
      isValid = false;
  }

  if (!/^[a-zA-Z\s\-]+$/.test(mname.value)) {
    Swal.fire({
      icon: 'error',
      title: 'Error!',
      text: 'Please input valid data. Try again'
  });
      isValid = false;
  }

  if (!/^[a-zA-Z\s\-]+$/.test(pos.value)) {
    Swal.fire({
      icon: 'error',
      title: 'Error!',
      text: 'Please input valid data. Try again'
  });
      isValid = false;
  }

  return isValid;
}

function validateField(element, regex, message) {
  resetValidation(element);
  if (!regex.test(element.value)) {
      showValidationError(element, message);
  }
}

function resetValidation(element) {
  element.style.borderColor = "";
  var errorSpan = element.nextElementSibling;
  if (errorSpan && errorSpan.classList.contains("validation-error")) {
      errorSpan.remove();
  }

}

function showValidationError(element, message) {
  element.style.borderColor = "red";
  var errorSpan = document.createElement("span");
  errorSpan.classList.add("validation-error");
  errorSpan.style.color = "red";
  errorSpan.style.fontSize = "12px";
  errorSpan.style.marginLeft= "10px";
  errorSpan.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
  element.parentNode.insertBefore(errorSpan, element.nextSibling);
}

