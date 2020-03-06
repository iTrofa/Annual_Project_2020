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
function serviceCategory() {
    var serviceCat = document.getElementById("existingCat");
    var newServiceCat = document.getElementById("newServiceCat")
    newServiceCat.value = serviceCat.value;
}
function checkFields(i) {
    if(i === 0){
        document.getElementById("errorSpan").style.display = "block";
        document.getElementById("errorSpan").innerHTML = "Please fill all inputs";
    }else if(i === 1){
        document.getElementById("errorSpan").style.display = "block";
        document.getElementById("errorSpan").style.color = "green";
        document.getElementById("errorSpan").innerHTML = "Service has been Added Successfully.";
    }
}