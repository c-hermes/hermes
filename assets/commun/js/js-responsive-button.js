
var button = document.querySelector('#navbar-toggler-button');
var croix = document.querySelector('#navbar-toggler-span');

document.querySelector('.navbar-toggler').addEventListener('click', function(e) {

  openCloseNavbarButton();

});


document.querySelector('.navbar-collapse').addEventListener('click', function(e) {

  button.click();

});

function openCloseNavbarButton(){

  if(croix.classList.contains("d-none") == true){
    // on cache les 3 barres et on affiche la croix
    button.classList.remove("navbar-toggler-icon");
    croix.classList.remove("d-none");
  }else{
    // on affiche les 3 barres et on cache la croix
    button.classList.add("navbar-toggler-icon");
    croix.classList.add("d-none");
  }

}
