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
    serviceHide.style.display = "none";
    var addService = document.getElementById("hiddenContainer");
    addService.style.display = "block";
    var footer = document.getElementById("footer");
    checkFooter();
}
function back2back() {
    var addService = document.getElementById("hiddenContainer");
    addService.style.display = "none";
    var serviceHide = document.getElementById("mainContainer");
    serviceHide.style.display = "block";
    checkFooter();
}
