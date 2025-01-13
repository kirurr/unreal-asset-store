document.addEventListener("DOMContentLoaded", function () {
  const main = new Splide("#main-carousel", {
    arrows: false,
    pagination: false,
    autoplay: true,
    rewind: true,
    gap: 4,
  });

  try {
    const thumbnail = new Splide("#thumbnails-carousel", {
      fixedWidth: 150,
      arrows: false,
      autoplay: true,
      rewind: true,
      pagination: false,
      isNavigation: true,
    });
    main.sync(thumbnail);
    main.mount();
    thumbnail.mount();
  } catch (e) {
    if (e.message === "[splide] null is invalid.") {
      console.log(
        "unable to mount thumbnails carousel, probably no extra images",
      );
      main.mount();
    } else {
      throw e;
    }
  }
});
