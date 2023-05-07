document.addEventListener("DOMContentLoaded", function() {
    var dropdownBtn = document.querySelector(".dropbtn");
    var dropdownContent = document.querySelector(".dropdown-content");

    dropdownBtn.addEventListener("click", function() {
    if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
    } else {
        dropdownContent.style.display = "block";
    }
    });
})