

const navLinkElements = document.querySelectorAll(".nav-link");
const windowPathname = window.location.pathname; 

navLinkElements.forEach(navLinkEl => {
    const navLinkPathname = new URL(navLinkEl.href).pathname;
    console.log(navLinkPathname);
    if (windowPathname === navLinkPathname) {
        navLinkEl.classList.add('active');
   }
});

function showSidebar() {
  //margin-left: 11.54%;
  var sideMenu = document.getElementById("navbar-bottom");
  var topMenu = document.getElementById("navbar-top");
  var main = document.getElementById("main");

  if (window.getComputedStyle(sideMenu).display == "block") {
    sideMenu.style.display = "none";
    main.style.marginLeft = "0%";
    topMenu.style.marginLeft = "0%";
  } else {
    sideMenu.style.display = "block";
    main.style.marginLeft = "11.54%";
    topMenu.style.marginLeft = "13.54%";
  }
  console.log(window.getComputedStyle(topMenu).marginLeft);
}

function showBikeFigures() {
  table = document.getElementById("bike-figures-table");
  
  if (window.getComputedStyle(table).display === "none") {
    table.style.display = "table";
  } else {
    table.style.display = "none";
  }
}

function showGear(val) {
  var gearVal = "";
  if (val == 'Urban') {
      gearVal = "Yes";
  } else {
      gearVal = "No";
  }

  document.getElementById('gear').value = gearVal;
}

