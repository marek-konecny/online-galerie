var nextPageButtons = document.getElementsByClassName("nextPageButton");


for (var i = 0; i < nextPageButtons.length; i++) {
  hideElement(nextPageButtons[i]);
}

function hideElement(element){
    element.style["display"] = 'none';
}