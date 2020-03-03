var countDate = 1;

// Filter table
$(document).ready(function(){
    $("#tableSearch").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

function myFunction(){
    const element = document.getElementById('userOption').value;
    if(element == '-----' || element == 'Hour(s)'){
        reservation = document.getElementById('noinput');
        reservation.type = 'hidden';
        document.getElementById('reservationInput').max = '8';
        document.getElementById('reservationInput').value = '1';
    }else{
        console.log(element);
        reservation = document.getElementById('noinput');
        reservation.type = 'number';
        reservation.placeholder = "How many hours per " + element.slice(0, -3);
        document.getElementById('reservationInput').max = '31';
        if(element == 'Year(s)'){
            document.getElementById('reservationInput').max = '3';
            document.getElementById('reservationInput').value = '1';
        }
    }
}

function payment() {
    var dateControl = document.getElementById("reservationDate");
    var endDates = document.getElementById("endDates");
    console.log(dateControl.value);
    var finaldate = formatDate(dateControl.value);
    var para = document.createElement("p");
    var remove = document.createElement("button");
    remove.id = countDate;
    remove.innerHTML = "Remove";
    remove.addEventListener("click", removeDate);
    para.innerText = "You Chose " +  finaldate + " as your " + countDate + "° date!";
    var paymentAnswer = document.getElementById("payementAnswer");
    if (paymentAnswer != null) {
        paymentAnswer.appendChild(para);
        paymentAnswer.appendChild(remove);
        countDate++;
    }else{
        console.log("error");
    }
    console.log(endDates);
    console.log(countDate);
    if (countDate == 2) {
        console.log("in");
        var removedates = document.createElement("button");
        removedates.innerHTML = "Remove All Dates";
        removedates.addEventListener("click", removeallDates);
        endDates.appendChild(removedates);
    }
}

function formatDate(date) {
    console.log(date.length);
    var finaldate = new Array(10);
    for (i=0;i<date.length;i++){
        finaldate[i] = date[i];
    }
    console.log(finaldate);
    return finaldate[8]+finaldate[9]+finaldate[7]+finaldate[5]+finaldate[6]+finaldate[4]+finaldate[0]+finaldate[1]+finaldate[2]+finaldate[3];
}
function removeDate(){
    console.log(this.id);

}

function removeallDates(){
    console.log(this);
    // Supprime tous les enfant d'un élément
    var element = document.getElementById("payementAnswer");
    while (element.firstChild) {
        element.removeChild(element.firstChild);
    }
    var element = document.getElementById("endDates");
    while (element.firstChild) {
        element.removeChild(element.firstChild);
    }
    countDate = 1;
}