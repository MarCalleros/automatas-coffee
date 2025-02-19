new Swiper('.card-wrapper', {
    loop: true,
    spaceBetween: 60,
  
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
      dynamicBullets: true
    },
  
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    breakpoints: {
        768: {
          slidesPerView: 2
        },
        1440: {
          slidesPerView: 3
        }
      }
  });