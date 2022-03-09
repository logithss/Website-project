
var signupBtn = document.querySelector('#signup');
var zipCode = document.querySelector('#zip-code');
var completeName = document.querySelectorAll('.complete-name');

function allLetters(input) {
    let letters = /^[A-Za-z]+$/;
    if (input.value.match(letters)) {
        return true;
    } else {
        return false;
    }
}

completeName.forEach(item => {
    item.addEventListener('keyup', event => {
        if (item.value != "") {
            if (!allLetters(item)) {
                window.alert("Please input valid name")
                item.value = "";
            }

        }
    })
});

function noSpecialChar(input) {
    var letters = /^[a-zA-Z0-9]+$/;
    if (input.value.match(letters)) {
        return true;
    } else {
        return false;
    }
}

zipCode.addEventListener('keyup', event => {
    if (zipCode.value != "") {
        if (!noSpecialChar(zipCode)) {
            window.alert("Please input valid ZIP code");
            zipCode.value = "";
        }
    }
});


signupBtn.addEventListener("click", function () {
    // if(completeName.forEach(item =>{item.value!=''})||){

    // }
    window.alert("SIGN UP");
});