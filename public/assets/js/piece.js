function myFunction() {
    let popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
    console.log('eee');
}

let popupTrigger = document.getElementById("popupTrigger");

popupTrigger.addEventListener('click', myFunction);
