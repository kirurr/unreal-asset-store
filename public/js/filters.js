document.addEventListener("DOMContentLoaded", () => {
  const filters = document.querySelector("#filters");

  filters.addEventListener("submit", filterEmptyParams);
  window.addEventListener("resize", updateInputsState);
})

function updateInputsState() {
  const form = document.querySelector("#filters");
  const searches = form.querySelectorAll("input[name='search']");
  const intervals = form.querySelectorAll("select[name='interval']");
  const limits = form.querySelectorAll("input[name='limit']");

  if (window.matchMedia("(max-width: 1024px)").matches) {
    searches[0].disabled = true;
    intervals[0].disabled = true;
    limits[0].disabled = true;

    searches[1].disabled = false;
    intervals[1].disabled = false;
    limits[1].disabled = false;
  } else {
    searches[1].disabled = true;
    intervals[1].disabled = true;
    limits[1].disabled = true;

    searches[0].disabled = false;
    intervals[0].disabled = false;
    limits[0].disabled = false;
  }

}

function filterEmptyParams(event) {
  event.preventDefault();
  updateInputsState();

  const form = event.target;
  const formData = new FormData(form);
  const params = new URLSearchParams();

  for (const [key, value] of formData.entries()) {
    if (value) {
      params.set(key, value);
    } else if (params.has(key) && !value) {
      params.delete(key);
    }
  }



  let actionUrl;
  if (params.size === 0) actionUrl = form.action;
  else actionUrl = form.action.split("?")[0] + "?" + params.toString();
  window.location.href = actionUrl;
}
