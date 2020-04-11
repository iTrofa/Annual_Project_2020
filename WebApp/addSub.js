function addSub(){
    var cat = document.getElementById("addSubCat").value;
    if(cat === "Basic"){
        document.getElementById("basicDiv").style.display = "block";
        document.getElementById("professionalDiv").style.display = "none";
        document.getElementById("enterpriseDiv").style.display = "none";
    }else if(cat === "Professional"){
        document.getElementById("basicDiv").style.display = "block";
        document.getElementById("professionalDiv").style.display = "block";
        document.getElementById("enterpriseDiv").style.display = "none";
    }else if(cat === "Enterprise"){
        document.getElementById("basicDiv").style.display = "block";
        document.getElementById("professionalDiv").style.display = "block";
        document.getElementById("enterpriseDiv").style.display = "block";
    }
}