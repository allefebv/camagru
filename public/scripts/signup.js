import * as utils from './utils.js'

const signup_request_button = document.getElementById('signup_request')
signup_request_button.onclick = () => {
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
    signup_request_button.classList.add('is-loading')
}

const signupResponse = arrayResponse => {
    document.getElementById('signup-password').value = "";
    document.getElementById('signup-password-confirm').value = "";
    if (arrayResponse['success']) {
        utils.closeModal('signup')
        utils.notifyUser("success", "An Email will be sent to you to validate your account")
        signup_request_button.classList.remove('is-loading')
        document.getElementById('signup-username').value = "";
        document.getElementById('signup-email').value = "";
    } else {
        for (var response in arrayResponse) {
            utils.notifyUser("error", utils.errorMessages[response])
        }
    }
}