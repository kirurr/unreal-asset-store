document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelector(".slides");
  const slide = document.querySelectorAll(".slide");
  const thumbnails = document.querySelectorAll(".thumbnail");

  let currentIndex = 0;
  let autoplayInterval;

  let startX = 0;
  let endX = 0;

  function updateSlider() {
    const width = slide[0].clientWidth;
    slides.style.transform = `translateX(-${currentIndex * width}px)`;
    thumbnails.forEach((thumb) => thumb.classList.remove("active"));
    thumbnails[currentIndex].classList.add("active");
  }

  function startAutoplay() {
    autoplayInterval = setInterval(() => {
      currentIndex = currentIndex < slide.length - 1 ? currentIndex + 1 : 0;
      updateSlider();
    }, 10000);
  }

  function handleSwipe() {
    const diffX = endX - startX;
    if (Math.abs(diffX) > 50) {
      stopAutoplay();
      if (diffX > 0) {
        currentIndex = currentIndex > 0 ? currentIndex - 1 : slide.length - 1;
      } else {
        currentIndex = currentIndex < slide.length - 1 ? currentIndex + 1 : 0;
      }
      updateSlider();
      startAutoplay();
    }
  }

  function stopAutoplay() {
    clearInterval(autoplayInterval);
  }
  thumbnails.forEach((thumb) => {
    thumb.addEventListener("click", () => {
      stopAutoplay();
      currentIndex = parseInt(thumb.getAttribute("data-index"));
      updateSlider();
      startAutoplay();
    });
  });

  slides.addEventListener("touchstart", (e) => {
    startX = e.touches[0].clientX;
  });

  slides.addEventListener("touchmove", (e) => {
    endX = e.touches[0].clientX;
  });

  slides.addEventListener("touchend", () => {
    handleSwipe();
  });

  window.addEventListener("resize", updateSlider);

  // Initialize active thumbnail and autoplay
  updateSlider();
  startAutoplay();
});
