const burger = document.querySelector('header .mobile-burger');
const close = document.querySelector('header .mobile-close');
const nav = document.querySelector('header nav');

burger.addEventListener('click', () => {
    nav.classList.add('open');
});

close.addEventListener('click', () => {
    nav.classList.remove('open');
});