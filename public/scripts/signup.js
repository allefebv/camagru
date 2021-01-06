import * as utils from './utils.js'

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('signup-password-confirm').addEventListener("keyup", (event) => {
        if(event.key !== "Enter" || !document.getElementById('modal-signup').classList.contains('is-active')) return;
        document.getElementById('signup-request').click();
        event.preventDefault();
    });
});

const signupRequestButton = document.getElementById('signup-request')
signupRequestButton.onclick = () => {
    let error = false;
    let username = document.getElementById('signup-username').value
    let email = document.getElementById('signup-email').value
    let password = document.getElementById('signup-password').value
    let passwordconfirm = document.getElementById('signup-password-confirm').value
    if (typeof username === 'string' && username.length > 19) {
        error = true;
        utils.notifyUser('error', 'username must be under 20 characters');
    }
    if (typeof email === 'string' && email.length > 29) {
        error = true;
        utils.notifyUser('error', 'email must be under 30 characters');
    }
    if (typeof password === 'string' && password.length > 49) {
        error = true;
        utils.notifyUser('error', 'password must be under 50 characters');
    }
    if (error === false) {
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