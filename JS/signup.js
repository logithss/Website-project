
var submitBtn = document.querySelector('#submit');
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
        if(item.value!=""){
            if (!allLetters(item))
                window.alert("ONLY LETTERS")
        }
    })
});

function noSpecialChar(input) {
    var letters = /^[^a-zA-Z0-9]+$/;
    if (input.value.match(letters)) {
        return true;
    } else {
        return false;
    }
}

zipCode.addEventListener('keyup', event => {
    if(noSpecialChar(zipCode)){
        window.alert("NO SPECIAL CHAR")
    }
});

/*
submitBtn.addEventListener("click", function () {
    window.alert("")
});
*/