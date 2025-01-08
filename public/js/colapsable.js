document.addEventListener("DOMContentLoaded", function () {
  document.addEventListener("click", (e) => {
    let target = e.target;
    const toggles = document.querySelectorAll(".sublist-toggle");

    if (target.classList.contains("sublist-toggle")) {
			e.preventDefault();
      const sublist = target.nextElementSibling;
      sublist.classList.toggle("open");
      toggleLinksTabIndex(sublist);

      for (const otherToggle of toggles) {
        if (otherToggle !== target) {
          const sublist = otherToggle.nextElementSibling;

          sublist.classList.remove("open");
          toggleLinksTabIndex(sublist);
        }
      }
    } else {
      for (const toggle of toggles) {
        const sublist = toggle.nextElementSibling;
        sublist.classList.remove("open");
        toggleLinksTabIndex(sublist);
      }
    }
  });
});

function toggleLinksTabIndex(sublist) {
  const links = sublist.querySelectorAll("a");
  for (const link of links) {
    if (sublist.classList.contains("open")) {
      link.tabIndex = 0;
    } else {
      link.tabIndex = -1;
    }
  }
}
