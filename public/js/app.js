

const navLinkElements = document.querySelectorAll(".nav-link");
const windowPathname = window.location.pathname; 

navLinkElements.forEach(navLinkEl => {
    const navLinkPathname = new URL(navLinkEl.href).pathname;
    if (windowPathname === navLinkPathname) {
        navLinkEl.classList.add('active');
   }
});

document.addEventListener('DOMContentLoaded', function ( ) {
    const hamburgerButton = document.getElementById('hamburger-button');
    const mobileMenu = document.querySelector('.mobile-menu');
  
    hamburgerButton.addEventListener('click', () =>
      mobileMenu.classList.toggle('active')
    );
  });

