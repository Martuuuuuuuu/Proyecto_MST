const track = document.querySelector('.carousel-track');
const prevBtn = document.querySelector('.carousel-arrow.prev');
const nextBtn = document.querySelector('.carousel-arrow.next');
const dotsContainer = document.querySelector('.carousel-dots');

const slides = track.querySelectorAll('img');
const totalSlides = slides.length;

let currentIndex = 0;
let autoPlayInterval;

// Crear los puntos indicadores
slides.forEach((_, index) => {
    const dot = document.createElement('span');

    dot.classList.add('dot');

    if (index === 0) {
        dot.classList.add('active');
    }

    dot.addEventListener('click', () => {
        goToSlide(index);
    });

    dotsContainer.appendChild(dot);
});

const dots = dotsContainer.querySelectorAll('.dot');

// Actualizar posición y punto activo
function updateCarousel(animate = true) {
    if (animate) {
        track.style.transition = 'transform 0.4s ease';
    } else {
        track.style.transition = 'none';
    }

    track.style.transform = `translateX(-${currentIndex * 100}%)`;

    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentIndex);
    });
}

// Ir a una imagen específica
function goToSlide(index) {
    currentIndex = (index + totalSlides) % totalSlides;

    updateCarousel(true);
    resetAutoPlay();
}

// Imagen siguiente
function nextSlide() {
    // Si estamos en la última imagen,
    // volvemos a la primera con la misma transición.
    if (currentIndex === totalSlides - 1) {
        currentIndex = 0;
    } else {
        currentIndex++;
    }

    updateCarousel(true);
    resetAutoPlay();
}

// Imagen anterior
function prevSlide() {
    if (currentIndex === 0) {
        currentIndex = totalSlides - 1;
    } else {
        currentIndex--;
    }

    updateCarousel(true);
    resetAutoPlay();
}

// Actualizar solamente los puntos
function updateDots() {
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentIndex);
    });
}

// Iniciar reproducción automática
function startAutoPlay() {
    clearInterval(autoPlayInterval);
    autoPlayInterval = setInterval(nextSlide, 3000);
}

// Reiniciar reproducción automática
function resetAutoPlay() {
    clearInterval(autoPlayInterval);
    startAutoPlay();
}

// Botones
nextBtn.addEventListener('click', nextSlide);
prevBtn.addEventListener('click', prevSlide);

// Pausar al pasar el mouse
track.addEventListener('mouseenter', () => {
    clearInterval(autoPlayInterval);
});

track.addEventListener('mouseleave', () => {
    startAutoPlay();
});

// Estado inicial
updateCarousel(false);
startAutoPlay();