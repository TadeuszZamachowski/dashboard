

const navLinkElements = document.querySelectorAll(".nav-link");
const windowPathname = window.location.pathname; 

navLinkElements.forEach(navLinkEl => {
    const navLinkPathname = new URL(navLinkEl.href).pathname;
    if (windowPathname === navLinkPathname) {
        navLinkEl.classList.add('active');
   }
});

function showSidebar() {
  var x = document.getElementById("navbar-bottom");

  if (window.getComputedStyle(x).left === "-100%") {
    x.style.left = "0";
  } else {
    x.style.left = "-100%";
  }
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
