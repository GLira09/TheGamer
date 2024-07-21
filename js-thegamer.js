document.addEventListener('DOMContentLoaded', function () {
    const carouselContainer = document.querySelector('.carousel-container');
    let translateValue = 0;
    let intervalId;
  
    function slideNext() {
      translateValue -= 100;
      if (translateValue < -200) {
        translateValue = 0;
      }
      carouselContainer.style.transform = `translateX(${translateValue}%)`;
    }
  
    function startCarousel() {
      intervalId = setInterval(slideNext, 3000);
    }
  
    function stopCarousel() {
      clearInterval(intervalId);
    }
  
    startCarousel();
  
    carouselContainer.addEventListener('mouseenter', stopCarousel);
    carouselContainer.addEventListener('mouseleave', startCarousel);
  });



