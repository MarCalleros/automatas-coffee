(function() {
    let cards = document.querySelectorAll('.card');
    const next = document.querySelector('.carousel__next-icon');
    const prev = document.querySelector('.carousel__prev-icon');

    const ACTIVE_CARDS = 3;
    const CARDS_SLIDE = 1;
    const EXTRA_CARDS_EACH_SIDE = 2;
    const REAL_CARDS = len - (EXTRA_CARDS_EACH_SIDE * 2);

    var len = cards.length;
    var i = EXTRA_CARDS_EACH_SIDE + 1;

    next.addEventListener('click', function() {
        if (i === len - EXTRA_CARDS_EACH_SIDE) {
            cards.forEach(card => {
                card.classList.remove('card--active');
            });
    
            cards[EXTRA_CARDS_EACH_SIDE + 0].classList.add('card--active');
            cards[EXTRA_CARDS_EACH_SIDE + 1].classList.add('card--active');
            cards[EXTRA_CARDS_EACH_SIDE + 2].classList.add('card--active', 'slide-in-right');
    
            setTimeout(() => {
                cards[EXTRA_CARDS_EACH_SIDE + 2].classList.remove('slide-in-right');
            }, 500);
        } else {
            let nextIndex = (i + 2) % len;
            let prevIndex = (i - 1 + len) % len; 
    
            cards[prevIndex].classList.remove('card--active');
            cards[nextIndex].classList.add('card--active', 'slide-in-right');
    
            setTimeout(() => {
                cards[nextIndex].classList.remove('slide-in-right');
            }, 500);
        }
    
        if (i === len - EXTRA_CARDS_EACH_SIDE) {
            i = EXTRA_CARDS_EACH_SIDE + 1;
        } else {
            i++;
        }
    });
    
    prev.addEventListener('click', function() {
        if (i === 1) {
            cards.forEach(card => {
                card.classList.remove('card--active');
            });
    
            cards[len - EXTRA_CARDS_EACH_SIDE - 1].classList.add('card--active');
            cards[len - EXTRA_CARDS_EACH_SIDE - 2].classList.add('card--active');
            cards[len - EXTRA_CARDS_EACH_SIDE - 3].classList.add('card--active', 'slide-in-left');
    
            setTimeout(() => {
                cards[len - EXTRA_CARDS_EACH_SIDE - 3].classList.remove('slide-in-left');
            }, 500);
        } else {
            let nextIndex = (i + 1) % len;
            let prevIndex = (i - 2 + len) % len; 
    
            cards[nextIndex].classList.remove('card--active');
            cards[prevIndex].classList.add('card--active', 'slide-in-left');
    
            setTimeout(() => {
                cards[prevIndex].classList.remove('slide-in-left');
            }, 500);
        };
    
        if (i === 1) {
            i = len - EXTRA_CARDS_EACH_SIDE - 2;
        } else {
            i--;
        }
    });

})();