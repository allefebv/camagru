document.addEventListener('DOMContentLoaded', () => {
    $navbarBurger = document.getElementById('myBurger');
    $navbarBurger.addEventListener('click', () => {
        const target = $navbarBurger.dataset.target;
        const $target = document.getElementById($navbarBurger.dataset.target);
        $navbarBurger.classList.toggle('is-active');
        $target.classList.toggle('is-active');
        });
});