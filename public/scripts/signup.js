import * as utils from './utils.js'

const signup_request_button = document.getElementById('signup_request')
signup_request_button.onclick = () => {
    let username = document.getElementById('signup-username').value
    let email = document.getElementById('signup-email').value
    let password = document.getElementById('signup-password').value
    let passwordconfirm = document.getElementById('signup-password-confirm').value
    utils.ajaxify(
        JSON.stringify({ username:username, email:email, password:password, passwordconfirm:passwordconfirm }),
        signupResponse,
        'index.php?url=signup'
    );
}

const signupResponse = arrayResponse => {
    document.getElementById('signup-password').value = "";
    if (arrayResponse['success']) {
        utils.closeModal('signup')
        utils.goToHome()
        utils.notifyUser("success", "Successful AccountCreation, an Email will be sent to you to validate your account")
        utils.notifyUser("success", "An Email will be sent to you to validate your account")
    } else {
        for (var response in arrayResponse) {
            utils.notifyUser("error", utils.errorMessages[response])
        }
    }
}