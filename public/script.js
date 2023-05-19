document.addEventListener("DOMContentLoaded", function () {
  var dropdownBtn = document.querySelector(".dropbtn");
  var dropdownContent = document.querySelector(".dropdown-content");

  dropdownBtn.addEventListener("click", function () {
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const prevButton = document.querySelector(".prev-button");
  const nextButton = document.querySelector(".next-button");
  const carouselImages = document.querySelectorAll(".carousel-image");

  let currentIndex = 0;

  prevButton.addEventListener("click", function () {
    currentIndex--;
    if (currentIndex < 0) {
      currentIndex = carouselImages.length - 1;
    }
    updateCarousel();
  });

  nextButton.addEventListener("click", function () {
    currentIndex++;
    if (currentIndex >= carouselImages.length) {
      currentIndex = 0;
    }
    updateCarousel();
  });

  function updateCarousel() {
    carouselImages.forEach(function (image, index) {
      if (index === currentIndex) {
        image.classList.add("active");
      } else {
        image.classList.remove("active");
      }
    });
  }

  function autoChangeImage() {
    setInterval(function () {
      currentIndex++;
      if (currentIndex >= carouselImages.length) {
        currentIndex = 0;
      }
      updateCarousel();
    }, 7000);
  }

  autoChangeImage();
});
