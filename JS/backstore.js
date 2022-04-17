$(function () {
    $('#header').load('header.html');
    $('#footer').load('footer.html');
});
let tabs = document.getElementsByClassName("tab");

function toggleTabsVisibility() {
    for(let i = 0, length = tabs.length; i < length; i ++){
        tabs[i].classList.toggle('show');
        document.body.classList.toggle('tabs-shown');
    }
}

function removeContent(){
    let backdoorLists = document.querySelectorAll(".list");
    let backdoorEdits = document.querySelectorAll(".edit");
    backdoorEdits.forEach(e => {
        e.style.display = 'none';
        e.style.visibility = 'hidden';
    });
    backdoorLists.forEach(e => {
        e.style.display = 'none';
        e.style.visibility = 'hidden';
    });
}

function changeEditContent(type){
    removeContent();

    let content = document.querySelector(".edit-"+type+"-container");
    console.log(content.className);
    content.style.display = 'flex';
    content.style.visibility = 'visible';

}

function changeMainContent(type){
    removeContent();
    let content = document.querySelector("."+type+"-list");
    content.style.display = 'flex';
    content.style.visibility = 'visible';
    console.log(content.className);
    let capitalTitle = type.charAt(0).toUpperCase() + type.slice(1);
    changeContentTitle(capitalTitle);
}

function changeContentTitle(title){
    const content_title = document.getElementById("content-title");
    const current_button = document.getElementById("current-button");
    content_title.textContent = title;
    current_button.textContent = title;
}

function filterItems(type) {
    // Declare variables
    let input, filter, ul, li, a, i, txtValue;
    input = document.getElementById('search-'+type);
    filter = input.value.toLowerCase();
    ul = document.getElementById("ul-"+type);
    let items = ul.getElementsByClassName(type);

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < items.length; i++) {
        if(type === 'product') a = items[i].getElementsByClassName('product-name')[0];
        if(type === 'user')    a = items[i].getElementsByClassName('user-name')[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toLowerCase().indexOf(filter) > -1) {
            items[i].style.display = "";
        } else {
            items[i].style.display = "none";
        }
    }
}

function alertDeletion(id){
    const jsonData= require('./students.json');
}