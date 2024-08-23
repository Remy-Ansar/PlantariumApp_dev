document.addEventListener('DOMContentLoaded', function () {
    const track = document.querySelector('.carousel-track');
    const slides = Array.from(track.children);
    const nextButton = document.querySelector('.carousel-button.next');
    const prevButton = document.querySelector('.carousel-button.prev');
    const slideWidth = slides[0].getBoundingClientRect().width;

    let currentIndex = 0;

    const moveToSlide = (track, currentSlide, targetSlide) => {
        const amountToMove = targetSlide.style.left;
        track.style.transform = `translateX(-${amountToMove})`;
        currentSlide.classList.remove('current-slide');
        targetSlide.classList.add('current-slide');
    };

    slides.forEach((slide, index) => {
        slide.style.left = `${slideWidth * index}px`;
    });

    nextButton.addEventListener('click', e => {
        if (currentIndex === slides.length - 1) return;
        currentIndex++;
        const currentSlide = track.querySelector('.current-slide');
        const nextSlide = slides[currentIndex];
        moveToSlide(track, currentSlide, nextSlide);
    });

    prevButton.addEventListener('click', e => {
        if (currentIndex === 0) return;
        currentIndex--;
        const currentSlide = track.querySelector('.current-slide');
        const prevSlide = slides[currentIndex];
        moveToSlide(track, currentSlide, prevSlide);
    });

    // Initialisation pour montrer la première slide comme active
    slides[0].classList.add('current-slide');
});