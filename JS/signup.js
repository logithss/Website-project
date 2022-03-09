
var signupBtn = document.querySelector('#signup');
var zipCode = document.querySelector('#zip-code');

function allLetters(input) {
    let letters = /^[A-Za-z]+$/;
    if (input.value.match(letters)) {
        return true;
    } else {
        return false;
    }
}

document.querySelectorAll('.complete-name').forEach(item => {
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
    window.alert("SIGN UP");
});