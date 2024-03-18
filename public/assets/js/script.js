//slider
let slides = document.querySelectorAll(".slide");
let dotsContainer = document.querySelector(".dots");
let prevBtn = document.querySelector(".move-buttons .prev");
let nextBtn = document.querySelector(".move-buttons .next");
let sliderIndex = 1;

createDots();
let dots = document.querySelectorAll(".dots .dot");

document.addEventListener("DOMContentLoaded", () => {
  // add eventListeners
  eventListeners();
  startSlides(sliderIndex);
});

setInterval((e) => {
  sliderIndex += 1;
  showCurrnetSlide(sliderIndex);
}, 5000);

function createDots() {
  for (let i = 0; i < numberOfDots; i++) {
    let span = document.createElement("span");
    span.classList.add("dot");
    dotsContainer.append(span);
  }
}

function eventListeners() {
  //slider event listerners
  nextBtn.addEventListener("click", () => {
    showplusSlide(1);
  });

  prevBtn.addEventListener("click", () => {
    showplusSlide(-1);
  });

  for (let i = 0; i < document.querySelectorAll(".dots .dot").length; i++) {
    dots[i].addEventListener("click", () => {
      showCurrnetSlide(i + 1);
    });
  }
}

function showCurrnetSlide(x) {
  startSlides((sliderIndex = x));
}

function showplusSlide(x) {
  startSlides((sliderIndex += x));
}

function startSlides(x) {
  if (x > slides.length) {
    sliderIndex = 1;
  }

  if (x < 1) {
    sliderIndex = slides.length;
  }
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }

  for (let i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace("active", "");
  }

  slides[sliderIndex - 1].style.display = "block";
  dots[sliderIndex - 1].className += " active";
}
