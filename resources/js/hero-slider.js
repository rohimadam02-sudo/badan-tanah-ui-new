document.addEventListener('DOMContentLoaded', function () {

    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');

    // Hentikan jika slider tidak ditemukan
    if (!slides.length) {
        return;
    }

    let currentSlide = 0;
    let slideInterval;


    // ==============================
    // TAMPILKAN SLIDE
    // ==============================

    function showSlide(index) {

        slides.forEach((slide, i) => {

            if (i === index) {
                slide.classList.remove('opacity-0');
                slide.classList.add('opacity-100');
            } else {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0');
            }

        });


        // Update titik
        dots.forEach((dot, i) => {

            if (i === index) {
                dot.classList.remove('bg-white/50');
                dot.classList.add('bg-white');
            } else {
                dot.classList.remove('bg-white');
                dot.classList.add('bg-white/50');
            }

        });

        currentSlide = index;
    }


    // ==============================
    // SLIDE BERIKUTNYA
    // ==============================

    function nextSlide() {

        let nextSlide = currentSlide + 1;

        if (nextSlide >= slides.length) {
            nextSlide = 0;
        }

        showSlide(nextSlide);
    }


    // ==============================
    // AUTO SLIDER
    // ==============================

    function startSlider() {

        slideInterval = setInterval(() => {
            nextSlide();
        }, 5000);

    }


    // ==============================
    // RESET TIMER
    // ==============================

    function resetSlider() {

        clearInterval(slideInterval);

        startSlider();
    }


    // ==============================
    // KLIK DOT
    // ==============================

    dots.forEach((dot, index) => {

        dot.addEventListener('click', function () {

            showSlide(index);

            resetSlider();

        });

    });


    // ==============================
    // MULAI
    // ==============================

    showSlide(0);

    startSlider();

});