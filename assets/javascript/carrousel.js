document.addEventListener('DOMContentLoaded', function () {
    const track = document.querySelector('.carousel-track');
    const slides = Array.from(track.children);
    const nextButton = document.querySelector('.carousel-button.next');
    const prevButton = document.querySelector('.carousel-button.prev');

    if (!track || slides.length === 0 || !nextButton || !prevButton) {
        console.error('Certains éléments du carrousel sont manquants dans le DOM.');
        return;
    }

    let slideWidth = slides[0].getBoundingClientRect().width;
    let currentIndex = 0;

    // Fonction pour mettre à jour la largeur de la diapositive en cas de redimensionnement de la fenêtre
    const updateSlideWidth = () => {
        slideWidth = slides[0].getBoundingClientRect().width;
        slides.forEach((slide, index) => {
            slide.style.left = `${slideWidth * index}px`;
        });
    };

    window.addEventListener('resize', updateSlideWidth);
    updateSlideWidth(); // Mettre à jour la largeur au chargement initial

    const moveToSlide = (currentSlide, targetSlide) => {
        const targetIndex = slides.indexOf(targetSlide);
        const amountToMove = slideWidth * targetIndex;
        track.style.transform = `translateX(-${amountToMove}px)`;
        currentSlide.classList.remove('current-slide');
        targetSlide.classList.add('current-slide');
    };

    nextButton.addEventListener('click', () => {
        if (currentIndex === slides.length - 1) {
            console.log('Vous êtes à la dernière diapositive, ne peut pas aller plus loin.');
            return;
        }
        const currentSlide = track.querySelector('.current-slide');
        currentIndex++;
        const nextSlide = slides[currentIndex];
        moveToSlide(currentSlide, nextSlide);
    });

    prevButton.addEventListener('click', () => {
        if (currentIndex === 0) {
            console.log('Vous êtes à la première diapositive, ne peut pas reculer.');
            return;
        }
        const currentSlide = track.querySelector('.current-slide');
        currentIndex--;
        const prevSlide = slides[currentIndex];
        moveToSlide(currentSlide, prevSlide);
    });

    // Initialiser la première slide comme active
    slides[0].classList.add('current-slide');
});
