const img = document.getElementById("profilePic");
img.addEventListener('click', function click() {
    const input = document.createElement('input');
    input.type = "file";
    input.name = "image";
    input.hidden = true;
    input.accept = ".png, .jpeg, .jpg";
    img.appendChild(input);
    input.click();
}, false);