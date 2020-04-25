function checkFooter() {
    var body = document.body,
        html = document.documentElement;

    var height = Math.max( body.scrollHeight, body.offsetHeight,
        html.clientHeight, html.scrollHeight, html.offsetHeight );
    //console.log(height);
    //console.log(screen.height);
    var footer = document.getElementById("footer");
    var header = document.getElementById("header");
    //console.log(footer.offsetHeight);
    //console.log(header.offsetHeight);
    var yourHeight = (screen.height) - (header.offsetHeight) + (footer.offsetHeight);
    //console.log(yourHeight);
    if(height > yourHeight){
        //console.log("scroll");
        var footer = document.getElementById("footer");
        footer.className = "";
        footer.className += "page-footer font-small bg-primary2";
    }else{
        //console.log("no scroll");
        var footer = document.getElementById("footer");
        footer.className = "";
        footer.classList += "page-footer font-small bg-primary2 fixed-bottom";
    }

}