let minusBtn = document.querySelector('#minus-button');
let plusBtn = document.querySelector('#plus-button');
let quantityInput = document.querySelector('#quantity');
let addBtn = document.querySelector('#add-button');
let unitprice = document.querySelector('#unit-price');
let totalPrice = document.querySelector('#total-price');

function updatePrice() {

    totalPrice.innerHTML = (quantityInput.value * unitprice.innerHTML).toFixed(2);
    //storeValue("totalPrice", totalPrice.innerHTML);
}

updatePrice();

plusBtn.addEventListener('click', function () {
    quantityInput.value++;
    updatePrice();
    //storeValue("ammount", quantityInput.value);
});

minusBtn.addEventListener('click', function () {
    if (quantityInput.value > 0) {
        quantityInput.value--;
        updatePrice();
        //storeValue("ammount", quantityInput.value);
    } else {
        window.alert("Quantity cannot be lower than 0");
        quantityInput.value = 0;
    }

});

quantityInput.addEventListener('input', function () {
    if (quantityInput.value < 0) {
        window.alert("Quantity cannot be lower than 0");
        quantityInput.value = 0;
    } else if (quantityInput.value.includes('.')) {
        window.alert("Quantity cannot be decimal");
        quantityInput.value = 0;
    } 
    updatePrice();
    /*else if (quantityInput.value === -0) {
        window.alert("Quantity cannot be -0");
        quantityInput.value = 0;
    }
    
    //storeValue("ammount", quantityInput.value);
    */
});

//storing ang getting when reload
window.onbeforeunload = function () {
    localStorage.setItem("quantityInput", quantityInput.value);
    localStorage.setItem("totalPrice", totalPrice.innerHTML);
}

window.onload = function () {
    quantityInput.value = localStorage.getItem("quantityInput");
    totalPrice.innerHTML = localStorage.getItem("totalPrice");
}

/*
    function storeValue(key, value) {
        localStorage.setItem(key, value);
    }

    function getStoredValue(key) {
        return localStorage.getItem(key);
    }

    // window.onunload = function(){
//     localStorage.clear()
// }
*/




/*
if (window.performance) {
    console.info("window.performance work's fine on this browser");
}
if (performance.navigation.type == 1) {
    //storing ang getting when reload
    window.onbeforeunload = function () {
        localStorage.setItem("quantityInput", quantityInput.value);
        localStorage.setItem("totalPrice", totalPrice.innerHTML);
    }

    window.onload = function () {
        quantityInput.value = localStorage.getItem("quantityInput");
        totalPrice.innerHTML = localStorage.getItem("totalPrice");
    }

} else {
        //clearing on close
        window.onunload = function () {
        localStorage.clear()
    }

}
*/