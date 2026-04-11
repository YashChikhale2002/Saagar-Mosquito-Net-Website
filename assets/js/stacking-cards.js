document.addEventListener("DOMContentLoaded", (event) => {
    // Select all cards with the class 'ul-about-3-tab'
    const cards = document.querySelectorAll('.ul-offer');
    const headingHeight = document.querySelector(".ul-offers .ul-section-heading").clientHeight;
    const headingTop = document.querySelector(".ul-offers .ul-section-heading").getBoundingClientRect().top;

    function positionCards() {
        cards.forEach((card, index) => {
            card.style.top = `calc(${headingHeight + 120}px + ${10}px + ${index * 20}px)`;
        });
    }

    function handleScroll() {
        const viewportHeight = window.innerHeight;
        let activeCard = null; // Store the currently active card

        cards.forEach((card, index) => {
            const rect = card.getBoundingClientRect();
            const top = rect.top;
            // When the top of the card reaches 80% of the viewport
            if (top <= viewportHeight * 0.4) {
                activeCard = card;
            }
        });
        // If an active card is found, remove 'active' from all other cards
        if (activeCard) {
            cards.forEach((card) => {
                if (card === activeCard) {
                    card.classList.add('active');
                } else {
                    card.classList.remove('active'); // Remove active from all others
                }
            });
        }
    }

    // Run once to position cards initially
    positionCards();

    // Run on scroll
    window.addEventListener('scroll', handleScroll);

    // Run on page load
    handleScroll();

})


// gork
// document.addEventListener("DOMContentLoaded", (event) => {
//     // Select all cards with the class 'ul-offer'
//     const cards = document.querySelectorAll('.ul-offer');
//     const headingHeight = document.querySelector(".ul-offers .ul-section-heading").clientHeight;
//     const headingTop = document.querySelector(".ul-offers .ul-section-heading").getBoundingClientRect().top;

//     function positionCards() {
//         cards.forEach((card, index) => {
//             card.style.position = 'sticky';
//             card.style.top = `calc(${headingHeight + 120}px + ${10}px + ${index * 20}px)`;
//         });
//     }

//     function handleScroll() {
//         const viewportHeight = window.innerHeight;
//         let activeCard = null; // Store the currently active card
//         const lastCard = cards[cards.length - 1];
//         const secondLastCard = cards[cards.length - 2];

//         // Determine active card
//         cards.forEach((card, index) => {
//             const rect = card.getBoundingClientRect();
//             const top = rect.top;
//             // When the top of the card reaches 40% of the viewport
//             if (top <= viewportHeight * 0.4) {
//                 activeCard = card;
//             }
//         });

//         // Handle active card class
//         if (activeCard) {
//             cards.forEach((card) => {
//                 if (card === activeCard) {
//                     card.classList.add('active');
//                 } else {
//                     card.classList.remove('active');
//                 }
//             });
//         }

//         // Check if the last card is within 20px of the second last card
//         const lastCardRect = lastCard.getBoundingClientRect();
//         const secondLastCardRect = secondLastCard ? secondLastCard.getBoundingClientRect() : null;

//         if (lastCardRect.top <= secondLastCardRect.top + 20) {
//             console.log(secondLastCardRect, 'fff', lastCardRect.top, 'fff', secondLastCardRect.top, 'llllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll');

//             // Calculate the offset needed to move all cards together
//             const scrollOffset = window.scrollY - (secondLastCardRect.top + window.scrollY - headingTop - headingHeight - 120 - (cards.length - 2) * 20 - 10);
//             cards.forEach((card, index) => {
//                 card.style.top = `calc(${headingHeight + 120}px + ${10}px + ${index * 20}px + ${scrollOffset}px)`;
//             });
//         } else {
//             // Reset to initial positions if not within 20px
//             positionCards();
//         }
//     }

//     // Run once to position cards initially
//     positionCards();

//     // Run on scroll
//     window.addEventListener('scroll', handleScroll);

//     // Run on page load
//     handleScroll();
// });



// my 2


// document.addEventListener("DOMContentLoaded", (event) => {
//     // Select all cards with the class 'ul-about-3-tab'
//     const cards = document.querySelectorAll('.ul-offer');
//     const lastCard = document.querySelector('.ul-offer:last-child');
//     const headingHeight = document.querySelector(".ul-offers .ul-section-heading").clientHeight;
//     const headingTop = document.querySelector(".ul-offers .ul-section-heading").getBoundingClientRect().top;
//     console.log(headingTop);

//     function positionCards() {
//         cards.forEach((card, index) => {
//             card.style.top = `calc(${headingHeight + 120}px + ${10}px + ${index * 20}px)`;
//         });
//     }

//     function handleScroll() {
//         const viewportHeight = window.innerHeight;
//         let activeCard = null; // Store the currently active card

//         cards.forEach((card, index) => {
//             const rect = card.getBoundingClientRect();
//             const top = rect.top;
//             // When the top of the card reaches 80% of the viewport
//             if (top <= viewportHeight * 0.4) {
//                 activeCard = card;
//             }
//         });
//         // If an active card is found, remove 'active' from all other cards
//         if (activeCard) {
//             cards.forEach((card) => {
//                 if (card === activeCard) {
//                     card.classList.add('active');
//                 } else {
//                     card.classList.remove('active'); // Remove active from all others
//                 }
//             });
//         }
//         if (lastCard.classList.contains("active")) {
//             const scrollOffset = window.scrollY - (lastCard.getBoundingClientRect().top + window.scrollY - lastCard.offsetTop); // Scroll distance since last card became active

//             console.log(scrollOffset);

//             cards.forEach((card, index) => {
//                 card.style.position = 'absolute';
//                 const initialTop = headingHeight + 120 + 10 + index * 20; // Initial top position
//                 card.style.top = `${initialTop - scrollOffset}px`;
//             });
//         }
//     }


//     // Run once to position cards initially
//     positionCards();

//     // Run on scroll
//     window.addEventListener('scroll', handleScroll);

//     // Run on page load
//     handleScroll();

// })



// gsap
// document.addEventListener("DOMContentLoaded", () => {
//     gsap.registerPlugin(ScrollTrigger);

//     // Initial card setup
//     gsap.set(".ul-offer", {
//         y: (i) => i * 20,
//         transformOrigin: "center top"
//     });

//     // Create timeline for card animations
//     const tl = gsap.timeline({
//         scrollTrigger: {
//             trigger: ".ul-offers-wrapper",
//             // pin: true,
//             pinSpacing: false,
//             start: "top 20%",
//             end: "+=200%",
//             scrub: 0.5,
//             markers: true
//         }
//     });

//     // Animate each card
//     document.querySelectorAll(".ul-offer").forEach((card, i, cards) => {
//         if (i < cards.length - 1) {
//             tl.to(cards[i], {
//                 scale: 0.85 + i * 0.05,
//                 backgroundColor: "#3498db",
//                 duration: 1,
//             })
//                 .from(cards[i + 1], {
//                     y: window.innerHeight,
//                     duration: 1
//                 }, "<");
//         }
//     });
// });


// gsap codepen
// gsap.registerPlugin(ScrollTrigger);

// // Constants
// let allowScroll = true;
// let scrollTimeout = gsap.delayedCall(1, () => (allowScroll = true)).pause();
// const time = 0.5;
// let animating = false;

// // Progressive enhancement
// gsap.set(".ul-offer", {
//     y: (index) => 20 * index,
//     transformOrigin: "center top"
// });

// // Dynamic timeline creation
// const cards = document.querySelectorAll(".ul-offer");
// const tl = gsap.timeline({ paused: true });

// cards.forEach((card, index) => {
//     // Add label for each card
//     tl.add(`card${index + 1}`);

//     // Scale down the previous card (if it exists) and change its background color
//     if (index > 0) {
//         tl.to(cards[index - 1], {
//             // scale: 1 - (0.05 * (cards.length - index)),
//             duration: time,
//         });
//         // Animate current card into view
//         tl.from(card, {
//             y: () => window.innerHeight,
//             duration: time
//         }, "<");
//     }
// });

// // Add final label to ensure we can scroll to the last card's position
// tl.add(`card${cards.length + 1}`);

// function tweenToLabel(direction, isScrollingDown) {
//     if (
//         (!tl.nextLabel() && isScrollingDown) ||
//         (!tl.previousLabel() && !isScrollingDown)
//     ) {
//         cardsObserver.disable();
//         return;
//     }
//     if (!animating && direction) {
//         animating = true;
//         tl.tweenTo(direction, { onComplete: () => (animating = false) });
//     }
// }

// // Observer plugin
// const cardsObserver = Observer.create({
//     wheelSpeed: -1,
//     onDown: (self) => tweenToLabel(tl.previousLabel(), false),
//     onUp: (self) => tweenToLabel(tl.nextLabel(), true),
//     tolerance: 10,
//     preventDefault: true,
//     onEnable(self) {
//         allowScroll = false;
//         scrollTimeout.restart(true);
//         let savedScroll = self.scrollY();
//         self._restoreScroll = () => self.scrollY(savedScroll);
//         document.addEventListener("scroll", self._restoreScroll, {
//             passive: false
//         });
//     },
//     onDisable: (self) =>
//         document.removeEventListener("scroll", self._restoreScroll)
// });

// cardsObserver.disable();

// // ScrollTrigger
// ScrollTrigger.create({
//     id: "STOP-SCROLL",
//     trigger: ".ul-offers-gsap",
//     pin: true,
//     pinSpacing: false,
//     start: "top 20%",
//     markers: true,
//     end: "+=100",
//     onEnter: (self) => {
//         if (cardsObserver.isEnabled) return;
//         cardsObserver.enable();
//     },
//     onEnterBack: (self) => {
//         if (cardsObserver.isEnabled) return;
//         cardsObserver.enable();
//     }
// });