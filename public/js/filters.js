document.addEventListener("DOMContentLoaded", () => { 
	const filters = document.querySelector("#filters");

	filters.addEventListener("submit", filterEmptyParams);
})
function filterEmptyParams(event) {
  const form = event.target;
  const formData = new FormData(form);
  const params = new URLSearchParams();

  for (const [key, value] of formData.entries()) {
    if (value) {
      params.append(key, value);
    }
  }

  // Изменяем URL перед отправкой
	
	let actionUrl;
	if (params.size === 0) actionUrl = form.action;
	else actionUrl = form.action.split("?")[0] + "?" + params.toString();
  window.location.href = actionUrl;

  // Отменяем стандартное поведение формы
  event.preventDefault();
}
