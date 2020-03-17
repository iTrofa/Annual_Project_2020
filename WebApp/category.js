function addCategory() {
    const req =  new XMLHttpRequest();
    const form = document.getElementById("formCategory");
    const data= new FormData(form);
    const reply = document.getElementById('replyCategory');
    const selectCategory = document.getElementById('existingCat');
    let result;
    req.open('POST','addCategory.php');
    req.send(data);
    req.onreadystatechange = function ()
    {
        if(req.readyState === 4){
            switch (req.status) {
                case 201:

                    result = JSON.parse(req.responseText);
                    reply.innerHTML = result.valid;
                    const newElement = document.createElement('option');
                    newElement.innerText = data.get('categoryName');
                    selectCategory.appendChild(newElement);
                    break;
                case 409:
                    result = JSON.parse(req.responseText);
                    reply.innerHTML = result.error;
                    break;
                case 412:
                    result = JSON.parse(req.responseText);
                    reply.innerHTML = result.error;
                    break;
            }
        }
    };
}

function displayCategory(button) {
    const form = document.getElementById("formCategory");
    if (button.name === "display") {
        form.style.display = 'block';
        button.value = "Hide form category";
        button.name = "hide";
    }
    else {
        form.style.display = 'none';
        button.name = "display";
        button.value = "Add Category";
    }
}