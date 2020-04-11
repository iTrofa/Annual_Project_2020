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
    if(element === 'Hour(s)'){
        document.getElementById('hourForm').style.display = "block";
        document.getElementById('dayForm').style.display = "none";
        document.getElementById('monthForm').style.display = "none";
        document.getElementById('yearForm').style.display = "none";
        reservation = document.getElementById('noinput');
        reservation.type = 'hidden';
        document.getElementById('reservationInput').max = '8';
        document.getElementById('reservationInput').value = '1';
        updatePrice();
    }else if (element === 'Day(s)'){
        console.log(element);
        document.getElementById('hourForm').style.display = "none";
        document.getElementById('dayForm').style.display = "block";
        document.getElementById('monthForm').style.display = "none";
        document.getElementById('yearForm').style.display = "none";
        reservation = document.getElementById('noinput');
        reservation.type = 'number';
        reservation.placeholder = "How many hours per " + element.slice(0, -3);
        document.getElementById('reservationInput').value = '';
        document.getElementById('reservationInput').max = '31';
        updatePrice();
    }else if (element === 'Month(s)'){
        document.getElementById('hourForm').style.display = "none";
        document.getElementById('dayForm').style.display = "none";
        document.getElementById('monthForm').style.display = "block";
        document.getElementById('yearForm').style.display = "none";
        document.getElementById('reservationInput').value = '';
        document.getElementById('reservationInput').max = '36';
        reservation = document.getElementById('noinput');
        reservation.type = 'number';
        updatePrice();
    }else if(element === 'Year(s)'){
        document.getElementById('hourForm').style.display = "none";
        document.getElementById('dayForm').style.display = "none";
        document.getElementById('monthForm').style.display = "none";
        document.getElementById('yearForm').style.display = "block";
        document.getElementById('reservationInput').value = '';
        document.getElementById('reservationInput').max = '3';
        reservation = document.getElementById('noinput');
        reservation.type = 'number';
        updatePrice();
    }
}

/*function payment() {
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
    if(countDate>5){
        console.log("in");
        checkFooter();
    }
}
*/
function retrieveHour() {
    const selectedTime = document.getElementById('hourInput').value;
    const date = new Date();
    nowTime = date.toLocaleDateString();
    const selectedYear = selectedTime[0] + selectedTime[1] + selectedTime[2] + selectedTime[3];
    const nowYear = nowTime[6] + nowTime[7] + nowTime[8] + nowTime[9];
    console.log(verify(selectedYear, nowYear));
    if(verify(selectedYear, nowYear)) {
        const selectedMonth = selectedTime [5] + selectedTime[6];
        const nowMonth = nowTime[3] + nowTime[4];
        console.log(verify(selectedMonth, nowMonth));
        if(verify(selectedMonth, nowMonth)) {
            const selectedDay = selectedTime [8] + selectedTime[9];
            const nowDay = nowTime[0] + nowTime[1];
            console.log(verify(selectedDay, nowDay));
            if(verify(selectedDay, nowDay)){
                console.log("rip");
            }else if(selectedDay > nowDay)
                console.log("nice");
            else console.log("nope");
        }else if(selectedMonth > nowMonth)
            console.log("nice");
        else console.log("nope");
    }else if(selectedYear > nowYear)
        console.log("nice");
    else console.log("nope");

}

function verify(selected, now){
    return selected === now;
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
/*function removeDate(){
    console.log(this.id);

}*/
/*
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
}*/

function updatePrice() {
    var place = document.getElementById("updatePrice");
    var price = document.getElementById("updatePrice").value / 8;
    var firstInput = document.getElementById('reservationInput').value;
    var timeVariable = document.getElementById('userOption').value;
    var hours = document.getElementById('noinput').value;

    if(timeVariable === 'Hour(s)') {
        price = price * firstInput;
    }else if(timeVariable === 'Day(s)'){
        price = price * firstInput * hours;
    }else if(timeVariable === "Month(s)"){
        price = price * firstInput * hours *31;
    }else if(timeVariable === "Year(s)"){
        price = price * firstInput * 12 *31 * hours;
    }

    (Math.round(price * 100) / 100).toFixed(2);
    price = price + "€";
    place.innerHTML = price;
}