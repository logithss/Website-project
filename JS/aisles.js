
function initializeBtns(){
    const plusBtns = document.getElementsByClassName('plus-btn');
    const minusBtns = document.getElementsByClassName('minus-btn');
    for (let i = 0; i < plusBtns.length; i++) {
        let plusBtn = plusBtns[i];
        let minusBtn = minusBtns[i];

        console.log()
        plusBtn.previousElementSibling.onclick = function () { return doNothing() };
        plusBtn.onclick   = function () { return incrementValue(plusBtn)  };
        minusBtn.onclick  = function () { return decrementValue(minusBtn) };
    }
}

function incrementValue(element){
    element.previousElementSibling.value++;
    return false;
}

function doNothing(){
    return false;
}

function decrementValue(element){
    if(element.nextElementSibling.value > 1){
        element.nextElementSibling.value--;
    }
    return false;
}

initializeBtns();
