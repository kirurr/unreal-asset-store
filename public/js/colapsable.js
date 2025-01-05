document.addEventListener("DOMContentLoaded", function () {
  const toggles = document.querySelectorAll(".sublist-toggle");

  for (const toggle of toggles) {
    const fn = toggleSublist.bind(null, toggle);
    toggle.addEventListener("click", fn);
  }
});

function toggleSublist(toggle, e) {
  e.preventDefault();
  const sublist = toggle.nextElementSibling;

  if (sublist.classList.contains("open")) {
    sublist.classList.remove("open");
  } else {
    sublist.classList.add("open");
  }
}
