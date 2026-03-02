document.addEventListener("DOMContentLoaded", function () {

    const checkAll = document.getElementById("checkAll");
    const checkboxes = document.querySelectorAll(".checkLabel");

    // Select All click
    checkAll.addEventListener("change", function () {
        checkboxes.forEach(cb => cb.checked = checkAll.checked);
    });

    // Update Select All jika manual check
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            const total = checkboxes.length;
            const checked = document.querySelectorAll(".checkLabel:checked").length;

            checkAll.checked = total === checked;
        });
    });

});