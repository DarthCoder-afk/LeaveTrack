document.getElementById("changePasswordForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch(this.action, {  // Use the form's action attribute
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        Swal.fire({
            title: "Password Update",
            text: data,
            icon: "success"
        }).then(() => location.reload()); // Reload page on success
    })
    .catch(error => {
        console.error("Error:", error);
    });
});

document.getElementById("updateUsernameForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch(this.action, {  // Use the form's action attribute
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        Swal.fire({
            title: "Username Update",
            text: data,
            icon: "success"
        }).then(() => location.reload()); // Reload page on success
    })
    .catch(error => {
        console.error("Error:", error);
    });
});
