document.addEventListener("DOMContentLoaded", () => {
	const carousels = document.querySelectorAll(".carousel");

	carousels.forEach((carousel) => {
		const track = carousel.querySelector(".carousel-track");
		const slides = Array.from(carousel.querySelectorAll(".carousel-track img"));
		const previousButton = carousel.querySelector(".carousel-arrow.prev");
		const nextButton = carousel.querySelector(".carousel-arrow.next");
		const dotsContainer = carousel.querySelector(".carousel-dots");
		let currentSlide = 0;

		if (!track || slides.length === 0) {
			return;
		}

		const updateCarousel = (index) => {
			currentSlide = (index + slides.length) % slides.length;
			track.style.transform = `translateX(-${currentSlide * 100}%)`;
			dotsContainer?.querySelectorAll(".dot").forEach((dot, dotIndex) => {
				dot.classList.toggle("active", dotIndex === currentSlide);
				dot.setAttribute("aria-current", dotIndex === currentSlide ? "true" : "false");
			});
		};

		slides.forEach((slide, index) => {
			const dot = document.createElement("button");
			dot.className = "dot";
			dot.type = "button";
			dot.setAttribute("aria-label", `Ver imagen ${index + 1}`);
			dot.addEventListener("click", () => updateCarousel(index));
			dotsContainer?.append(dot);
		});

		previousButton?.addEventListener("click", () => updateCarousel(currentSlide - 1));
		nextButton?.addEventListener("click", () => updateCarousel(currentSlide + 1));
		updateCarousel(0);
	});
});
