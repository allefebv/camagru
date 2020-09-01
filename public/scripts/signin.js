import * as utils from './utils.js'

const signinRequestButton = document.getElementById('signin_request')
signinRequestButton.onclick = () => {
    let email = document.getElementById('signin-email').value
    let password = document.getElementById('signin-password').value
    utils.ajaxify(
        JSON.stringify({ email:email, password:password }),
        signinResponse,
        'index.php?url=signin'
    );
}

const signinResponse = arrayResponse => {
    document.getElementById('signin-password').value = "";
    if (arrayResponse['success']) {
        utils.closeModal('signin')
        utils.goToHome()
        utils.notifyUser("success", "Successful Connection")
        sessionStorage.setItem('logged', true)
    } else {
        for (let response in arrayResponse) {
            utils.notifyUser("error", utils.errorMessages[response])
        }
    }
}

const forgotPasswordRequestButton = document.getElementById('password_request')
forgotPasswordRequestButton.onclick = () => {
    let email = document.getElementById('signin-email').value
    utils.ajaxify(
        JSON.stringify({ email:email }),
        forgotPasswordResponse,
        'index.php?url=password'
    );
}

const forgotPasswordResponse = arrayResponse => {
    if (arrayResponse['success']) {
        utils.closeModal('signin')
        utils.goToHome()
        utils.notifyUser("success", "An Email with your new password has been sent")
    } else {
        for (var response in arrayResponse) {
            utils.notifyUser("error", utils.errorMessages[response])
        }
    }
}