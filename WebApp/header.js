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
    console.log(dateControl.value);
    var p = document.createElement("p");
    p.innerHTML = dateControl.value;
    var paymentAnswer = document.getElementById("paymentAnswer");
    paymentAnswer.innerHTML = datecontrol.value;
}





