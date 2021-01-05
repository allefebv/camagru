import * as utils from './utils.js'

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('signup-password-confirm').addEventListener("keyup", (event) => {
        if(event.key !== "Enter" || !document.getElementById('modal-signup').classList.contains('is-active')) return;
        document.getElementById('signin-request').click();
        event.preventDefault();
    });
});

const signupRequestButton = document.getElementById('signup-request')
signupRequestButton.onclick = () => {
    let username = document.getElementById('signup-username').value
    let email = document.getElementById('signup-email').value
    let password = document.getElementById('signup-password').value
    let passwordconfirm = document.getElementById('signup-password-confirm').value
    utils.ajaxify(
        JSON.stringify({
            signup:1,
            username:username,
            email:email,
            password:password,
            passwordconfirm:passwordconfirm }),
        signupResponse,
        'index.php?url=signup'
    );
    signupRequestButton.classList.add('is-loading')
}

const signupResponse = arrayResponse => {
    signupRequestButton.classList.remove('is-loading')
    document.getElementById('signup-password').value = "";
    document.getElementById('signup-password-confirm').value = "";
    if (arrayResponse['success']) {
        utils.closeModal('signup')
        utils.notifyUser("success", "An Email will be sent to you to validate your account")
        document.getElementById('signup-username').value = "";
        document.getElementById('signup-email').value = "";
    } else {
        for (var response in arrayResponse) {
            utils.notifyUser("error", utils.errorMessages[response])
        }
    }
}