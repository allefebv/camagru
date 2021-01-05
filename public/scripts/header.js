import * as utils from './utils.js'

document.addEventListener('DOMContentLoaded', () => {
    let navbarBurger = document.getElementById('myBurger')
    let navbarMenu = document.getElementById('navMenu')
    navbarBurger.addEventListener('click', () => {
        navbarBurger.classList.toggle('is-active')
        navbarMenu.classList.toggle('is-active')
    });
    utils.initOpenModals()
    utils.initCloseModals()

    let logout = document.getElementById('logout-button');
    logout && logout.addEventListener('click', () => {
        sessionStorage.removeItem('username');
        sessionStorage.removeItem('userId');
    })
});