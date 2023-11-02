

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
  
  if (x.style.left === "-100%") {
    x.style.left = "0";
  } else {
    x.style.left = "-100%";
  }
  console.log(x);
}


