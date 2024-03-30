let carousel = document.querySelector('.carousel');
let carouselItems = document.querySelectorAll('.event-image');
let currentIndex = 0;
let totalItems = carouselItems.length;

function prevImage() {
    currentIndex = (currentIndex - 1 + totalItems) % totalItems;
    updateCarousel();
}

function nextImage() {
    currentIndex = (currentIndex + 1) % totalItems;
    updateCarousel();
}

function updateCarousel() {
    carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
}
