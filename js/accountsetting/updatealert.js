// Change Password Confirmation + Validation
document.getElementById("changePasswordForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let form = this;
    let newPassword = document.getElementById("new_password").value;
    let confirmPassword = document.getElementById("confirm_password").value;

    if (newPassword !== confirmPassword) {
        let errorText = document.getElementById("errorText");
        let errorModal = new bootstrap.Modal(document.getElementById("errorModal"));
        errorText.innerText = "New password and confirm password do not match!";
        errorModal.show();
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to change your password.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                let isError = data.toLowerCase().includes("error");
                Swal.fire({
                    title: "Password Update",
                    text: data,
                    icon: isError ? "error" : "success"
                }).then(() => {
                    if (!isError) location.reload();
                });
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
    });
});


// Update Username Confirmation + Validation
document.getElementById("updateUsernameForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let form = this;
    let newUsername = document.getElementById("new_username").value;

    if (newUsername.trim() === "") {
        let errorText = document.getElementById("errorText");
        let errorModal = new bootstrap.Modal(document.getElementById("errorModal"));
        errorText.innerText = "Username cannot be empty!";
        errorModal.show();
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: `You are about to change your username to "${newUsername}".`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                let isError = data.toLowerCase().includes("error");
                Swal.fire({
                    title: "Username Update",
                    text: data,
                    icon: isError ? "error" : "success"
                }).then(() => {
                    if (!isError) location.reload();
                });
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
    });
});
