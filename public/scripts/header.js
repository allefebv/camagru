import * as utils from './utils.js'

document.addEventListener('DOMContentLoaded', () => {
    var navbarBurger = document.getElementById('myBurger');
    navbarBurger.addEventListener('click', () => {
        const target = navbarBurger.dataset.target;
        navbarBurger.classList.toggle('is-active');
        target.classList.toggle('is-active');
        });

        initModals()
});

const initModals = () => {
    var modals = document.getElementsByClassName('modal')
    for (var modal of modals) {
        var strpos = modal.id.indexOf('-') + 1
        utils.openModal(modal.id.slice(strpos))
        modal.appendChild(document.getElementById(modal.id + "-content"))
    }

    var modalCloseList = document.querySelectorAll('[data-bulma-modal=close]')
    for (var button of modalCloseList) {
        button.addEventListener('click', function() {
            var modals = document.getElementsByClassName('modal')
            for (var modal of modals) {
                modal.classList.remove('is-active')
            }
        })
    }
}