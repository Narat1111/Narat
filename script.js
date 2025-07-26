document.addEventListener('DOMContentLoaded', () => {
    // Carousel functionality
    const carouselContainer = document.querySelector('.carousel-container');
    const slides = document.querySelectorAll('.carousel-slide');
    const prevButton = document.querySelector('.nav-button.prev');
    const nextButton = document.querySelector('.nav-button.next');
    const dotsContainer = document.querySelector('.carousel-dots');

    let currentSlide = 0;
    const totalSlides = slides.length;

    // Create dots for navigation
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement('span');
        dot.classList.add('dot');
        dot.setAttribute('data-slide-index', i);
        dotsContainer.appendChild(dot);
    }
    const dots = document.querySelectorAll('.dot');

    function updateCarousel() {
        // Move the carousel to the current slide
        carouselContainer.style.transform = `translateX(-${currentSlide * 100}%)`;

        // Update active dot
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    function showNextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateCarousel();
    }

    function showPrevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateCarousel();
    }

    // Event listeners for navigation buttons
    nextButton.addEventListener('click', showNextSlide);
    prevButton.addEventListener('click', showPrevSlide);

    // Event listeners for dots
    dots.forEach(dot => {
        dot.addEventListener('click', (event) => {
            const slideIndex = parseInt(event.target.getAttribute('data-slide-index'));
            currentSlide = slideIndex;
            updateCarousel();
        });
    });

    // Initial update to show the first slide and activate the first dot
    updateCarousel();

    // Optional: Auto-play carousel
    let autoPlayInterval = setInterval(showNextSlide, 5000); // Change slide every 5 seconds

    // Optional: Pause auto-play on hover
    carouselContainer.addEventListener('mouseenter', () => {
        clearInterval(autoPlayInterval);
    });
    carouselContainer.addEventListener('mouseleave', () => {
        autoPlayInterval = setInterval(showNextSlide, 5000);
    });


    // General interactivity (from previous example)
    // Removed the alert for download icons as href="download" handles it directly.

    // Add a simple scroll-to-top on header click (just an idea)
    document.querySelector('.header').addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
