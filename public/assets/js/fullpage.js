const body = document.querySelector("body");
const img = document.querySelector("#img-box img");
const fullPage = document.querySelector("#fullpage");
const closeFullPage = document.querySelector(".fullpage-close");

img.addEventListener("click", () => {
  window.scrollTo(0, 0);
  body.classList.add("nav-open");
  fullPage.style.backgroundImage = "url(" + img.src + ")";
  fullPage.style.display = "block";
});

closeFullPage.addEventListener("click", () => {
  body.classList.remove("nav-open");
  fullPage.style.backgroundImage = "none";
  fullPage.style.display = "none";
});
