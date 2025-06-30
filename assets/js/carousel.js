const images = document.querySelectorAll('#carousel-images img');
const totalSlides = images.length;
let currentIndex = 0;

const dotsContainer = document.getElementById('carousel-dots');
for (let i = 0; i< totalSlides; i++){
    const dot = document.createElement('span');
    dot.classList.add('dot');
    dot.onclick = () => goToSlide(i);
    dotsContainer.appendChild(dot);
}

const dots = document.querySelectorAll('.dot');

function updateCarousel(){
    document.getElementById('carousel-images').style.transform = `translateX(-${currentIndex * 800}px)`
    dots[currentIndex].classList.add('active');
}

function nextSlide(){
    currentIndex = (currentIndex + 1) % totalSlides;
    updateCarousel();
}

function prevSlide(){
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    updateCarousel();
}

function goToSlide(index){
    currentIndex = index;
    updateCarousel();
}

setInterval(nextSlide, 4000);
updateCarousel();
