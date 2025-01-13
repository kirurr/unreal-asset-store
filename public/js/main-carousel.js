document.addEventListener("DOMContentLoaded", () => {
  const main = new Splide("#main-carousel", {
    arrows: false,
    autoplay: true,
		gap: 4,
  });

	const thumbnails = new Splide("#thumbnails-carousel", {
		arrows: false,
		autoplay: true,
		rewind    : true,
		pagination: false,
		isNavigation: true,
	});

	main.sync(thumbnails);
  main.mount();
	thumbnails.mount();
});
