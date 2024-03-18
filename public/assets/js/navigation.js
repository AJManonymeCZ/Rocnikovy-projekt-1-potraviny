//sidebar
const openButton = document.querySelector(".navbar .bx-menu");
const closeBtn = document.querySelector(".bx-x");

const navLiks = document.querySelector(".nav-links");
const links = document.querySelectorAll(".profile-sub-menu li");

//navigation event listerners
openButton.addEventListener("click", () => {
  navLiks.style.left = "0";
  document.body.classList.add("nav-open");
});

closeBtn.addEventListener("click", () => {
  navLiks.style.left = "-100%";
  document.body.classList.remove("nav-open");
});

links.forEach((link) => {
  link.addEventListener("click", (e) => {
    if (window.innerWidth <= 800) {
      navLiks.style.left = "-100%";
      document.body.classList.remove("nav-open");
    }
  });
});

//arrow
const subMenu = document.querySelector(".profile-sub-menu");
const arrow = document.querySelector(".links .drop");

if (arrow != undefined) {
  arrow.addEventListener("click", (e) => {
    subMenu.classList.toggle("show");
    subMenu.classList.toggle("visibility");
  });
}
