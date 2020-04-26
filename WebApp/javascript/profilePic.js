const img = document.getElementById("profilePic");
const inp = document.getElementById("input");

img.addEventListener('click', function () {
    const input = document.createElement('input');
    input.type = "file";
    input.name = "image";
    input.hidden = true;
    input.accept = ".png, .jpeg, .jpg";
    input.click();
    inp.appendChild(input);

}, false);