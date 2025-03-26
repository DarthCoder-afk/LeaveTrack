const dropZone = document.getElementById("drop-zone");
const fileInput = document.getElementById("leave_form");
const fileNameDisplay = document.getElementById("filename");

// Click to open file dialog
dropZone.addEventListener("click", () => fileInput.click());

    // Handle file selection via input
    fileInput.addEventListener("change", function () {
    if (fileInput.files.length > 0) {
        fileNameDisplay.textContent = "Selected file: " + fileInput.files[0].name;
    }
    });

// Handle drag over event
dropZone.addEventListener("dragover", (e) => {
  e.preventDefault();
  dropZone.classList.add("dragover");
});

// Handle drag leave event
dropZone.addEventListener("dragleave", () => dropZone.classList.remove("dragover"));

// Handle drop event
dropZone.addEventListener("drop", (e) => {
  e.preventDefault();
  dropZone.classList.remove("dragover");

  if (e.dataTransfer.files.length > 0) {
    fileInput.files = e.dataTransfer.files;
    fileNameDisplay.textContent = "Selected file: " + fileInput.files[0].name;
  }
});