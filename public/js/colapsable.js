document.addEventListener("DOMContentLoaded", function () {
  const toggles = document.querySelectorAll(".sublist-toggle");

  for (const toggle of toggles) {
    toggle.addEventListener("click", (e) => {
      e.preventDefault();
      const sublist = toggle.nextElementSibling;

      sublist.classList.toggle("open");
      for (const otherToggle of toggles) {
        if (otherToggle !== toggle) {
          const sublist = otherToggle.nextElementSibling;
          sublist.classList.remove("open");
        }
      }
    });

    toggle.addEventListener("mouseleave", () => {
      const sublist = toggle.nextElementSibling;
      sublist.classList.remove("open");
    });
  }
});
