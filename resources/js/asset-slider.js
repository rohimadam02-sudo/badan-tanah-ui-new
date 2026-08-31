document.addEventListener('DOMContentLoaded', () => {

    const slider = document.getElementById('assetSlider');
    const dots = document.querySelectorAll('.asset-dot');
    const cards = document.querySelectorAll('.asset-card');

    if (!slider || !cards.length || !dots.length) {
        return;
    }

    function slideAssets(index) {

        const cardWidth = cards[0].offsetWidth;

        slider.style.transform =
            `translateX(-${cardWidth * index}px)`;

        dots.forEach((dot, i) => {

            if (i === index) {
                dot.classList.remove('bg-gray-300');
                dot.classList.add('bg-blue-700');
            } else {
                dot.classList.remove('bg-blue-700');
                dot.classList.add('bg-gray-300');
            }

        });
    }

    dots.forEach((dot) => {

        dot.addEventListener('click', () => {

            const index = Number(dot.dataset.slide);

            slideAssets(index);

        });

    });

});