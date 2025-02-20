document.getElementById("changePasswordForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent form submission

    let newPassword = document.getElementById("new_password").value;
    let confirmPassword = document.getElementById("confirm_password").value;
    let errorText = document.getElementById("errorText");
    let errorModal = new bootstrap.Modal(document.getElementById("errorModal"));

});

document.getElementById("updateUsernameForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent form submission

    let newUsername = document.getElementById("new_username").value;
    if (newUsername.trim() === "") {
        let errorText = document.getElementById("errorText");
        let errorModal = new bootstrap.Modal(document.getElementById("errorModal"));
        errorText.innerText = "Username cannot be empty!";
        errorModal.show();
        return;
    }
});