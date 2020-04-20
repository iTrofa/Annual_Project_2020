$(document).ready(function(){
    $("#serviceSearch").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".row .col").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

function hideServices() {
    var serviceHide = document.getElementById("mainContainer");
    serviceHide.style.display = "block";
    var addService = document.getElementById("hiddenContainer");
    addService.style.display = "none";
    /*window.location = "addServices.php?add=1";*/
    checkFooter();
}
function back2back() {
    var addService = document.getElementById("hiddenContainer");
    addService.style.display = "block";
    var serviceHide = document.getElementById("mainContainer");
    serviceHide.style.display = "none";
    /*window.location = "addServices.php";*/
    checkFooter();
}