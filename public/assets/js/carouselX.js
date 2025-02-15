(function() {
    let amountCardsShowed;
    let lastCardsShowed;

    const cards = document.querySelectorAll('.card');
    let cardsWithExtraCards;

    const next = document.querySelector('.carousel__next-icon');
    const prev = document.querySelector('.carousel__prev-icon');

    window.onload = function() {
        amountCardsShowed = setCardsShowed(window.innerWidth);
        lastCardsShowed = 0;

        showDefaultCards(amountCardsShowed, cards);
        insertExtraCards(amountCardsShowed, cards);

        cardsWithExtraCards = getCardsWithExtraCards(cardsWithExtraCards);
    };

    window.addEventListener("resize", function() {
        amountCardsShowed = setCardsShowed(window.innerWidth);

        if (lastCardsShowed != amountCardsShowed) {
            lastCardsShowed = amountCardsShowed;

            showDefaultCards(amountCardsShowed, cards);
            insertExtraCards(amountCardsShowed, cards);

            cardsWithExtraCards = getCardsWithExtraCards(cardsWithExtraCards);
        }
    });

    next.addEventListener('click', function() {
        let cardsShowed = document.querySelectorAll('.card--active');
        let lastCardShowed = parseInt(cardsShowed[cardsShowed.length - 1].getAttribute('carousel-index'), 10);
        let firstCardShowed = parseInt(cardsShowed[0].getAttribute('carousel-index'), 10);

        let nextIndex = (lastCardShowed + 1) % cardsWithExtraCards.length;

        if (nextIndex === 0) {
            removeActiveClass(cardsWithExtraCards);

            for (let i = amountCardsShowed - 1; i < (amountCardsShowed * 2) - 1; i++) {
                cardsWithExtraCards[i].classList.add('card--active');
            }

        } else {
            cardsWithExtraCards[nextIndex].classList.add('card--active');
            cardsWithExtraCards[firstCardShowed].classList.remove('card--active');
        }
    });

    prev.addEventListener('click', function() {
        let cardsShowed = document.querySelectorAll('.card--active');
        let lastCardShowed = parseInt(cardsShowed[cardsShowed.length - 1].getAttribute('carousel-index'), 10);
        let firstCardShowed = parseInt(cardsShowed[0].getAttribute('carousel-index'), 10);

        let prevIndex = (firstCardShowed - 1 + cardsWithExtraCards.length) % cardsWithExtraCards.length;

        if (prevIndex === cardsWithExtraCards.length - 1) {
            removeActiveClass(cardsWithExtraCards);

            for (let i = cardsWithExtraCards.length - amountCardsShowed; i > cardsWithExtraCards.length - (amountCardsShowed * 2); i--) {
                cardsWithExtraCards[i].classList.add('card--active');
            }
            
        } else {
            cardsWithExtraCards[prevIndex].classList.add('card--active');
            cardsWithExtraCards[lastCardShowed].classList.remove('card--active');
        }
    });
})();

function setCardsShowed(screenWidth) {
    if (screenWidth < 768) {
        return 1;
    } else if (screenWidth < 1440) {
        return 2;
    } else {
        return 3;
    }
}

function showDefaultCards(amountCardsShowed, cards) {
    removeActiveClass(cards);

    for (let i = 0; i < amountCardsShowed; i++) {
        cards[i].classList.add('card--active');
    }
}

function removeActiveClass(cards) {
    cards.forEach(card => {
        card.classList.remove('card--active');
    });
}

function insertExtraCards(amountCardsShowed, cards) {
    cardsCretedPrev = document.querySelectorAll('.card--created');

    cardsCretedPrev.forEach(card => {
        card.remove();
    });

    if (amountCardsShowed === 1) {return};

    let cardLeftSide = createCard(cards[cards.length - 1]);
    cards[0].parentNode.insertBefore(cardLeftSide, cards[0]);
        
    let cardRightSide = createCard(cards[0]);
    cards[0].parentNode.insertBefore(cardRightSide, cards[cards.length - 1].nextSibling);

    if (amountCardsShowed === 3) {
        let cardLeftSide2 = createCard(cards[cards.length - 2]);
        cards[0].parentNode.insertBefore(cardLeftSide2, cardLeftSide);

        let cardRightSide2 = createCard(cards[1]);
        cards[0].parentNode.insertBefore(cardRightSide2, cardRightSide.nextSibling);
    }
}

function createCard(originalcard) {
    const originalAlt = originalcard.querySelector('.card__image').alt;
    const originalSrc = originalcard.querySelector('.card__image').src;

    const originalTitle = originalcard.querySelector('.card__title').textContent;
    const originalPrice = originalcard.querySelector('.card__price').textContent;
    const originalDescription = originalcard.querySelector('.card__description').textContent;

    const originalCardFooter = originalcard.querySelector('.card__footer');

    let card = document.createElement('div');
    card.classList.add('card');
    card.classList.add('card--created');

    let img = document.createElement('img');
    img.src = originalSrc;
    img.alt = originalAlt;
    img.classList.add('card__image');

    let cardInformation = document.createElement('div');
    cardInformation.classList.add('card__information');

    let title = document.createElement('h3');
    title.textContent = originalTitle;
    title.classList.add('card__title');

    let price = document.createElement('p');
    price.textContent = originalPrice;
    price.classList.add('card__price');

    let description = document.createElement('p');
    description.textContent = originalDescription;
    description.classList.add('card__description');

    let cardFooter = originalCardFooter.cloneNode(true);

    cardInformation.appendChild(title);
    cardInformation.appendChild(price);
    cardInformation.appendChild(description);
    
    card.appendChild(img);
    card.appendChild(cardInformation);
    card.appendChild(cardFooter);

    return card;
}

function getCardsWithExtraCards(cardsWithExtraCards) {
    cardsWithExtraCards = document.querySelectorAll('.card');

    for (let i = 0; i < cardsWithExtraCards.length; i++) {
        cardsWithExtraCards[i].setAttribute('carousel-index', i);
    }

    return cardsWithExtraCards;
}