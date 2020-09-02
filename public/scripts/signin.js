import * as utils from './utils.js'

const signinRequestButton = document.getElementById('signin-request')
signinRequestButton.onclick = () => {
    let email = document.getElementById('signin-email').value
    let password = document.getElementById('signin-password').value
    utils.ajaxify(
        JSON.stringify({ email:email, password:password }),
        signinResponse,
        'index.php?url=signin'
    );
    signinRequestButton.classList.add('is-loading')
}

const signinResponse = arrayResponse => {
    signinRequestButton.classList.remove('is-loading')
    document.getElementById('signin-password').value = "";
    if (arrayResponse['success']) {
        utils.closeModal('signin')
        utils.reloadPage(2000)
        utils.notifyUser("success", "Successful Connection")
        sessionStorage.setItem('logged', true)
    } else {
        for (let response in arrayResponse) {
            utils.notifyUser("error", utils.errorMessages[response])
        }
    }
}

const forgotPasswordRequestButton = document.getElementById('forgot-password-request')
forgotPasswordRequestButton.onclick = () => {
    let email = document.getElementById('signin-email').value
    utils.ajaxify(
        JSON.stringify({ email:email }),
        forgotPasswordResponse,
        'index.php?url=password'
    );
    forgotPasswordRequestButton.classList.add('is-loading')
}

const forgotPasswordResponse = arrayResponse => {
    forgotPasswordRequestButton.classList.remove('is-loading')
    if (arrayResponse['success']) {
        utils.closeModal('signin')
        utils.notifyUser("success", "An Email with your new password has been sent")
    } else {
        for (var response in arrayResponse) {
            utils.notifyUser("error", utils.errorMessages[response])
        }
    }
}

const resendActivationLinkRequestButton = document.getElementById('resend-activation-link-request')
resendActivationLinkRequestButton.onclick = () => {
    let email = document.getElementById('signin-email').value
    utils.ajaxify(
        JSON.stringify({
            resendLink:1,
            email:email
        }),
        resendActivationLinkResponse,
        'index.php?url=signup'
    );
    resendActivationLinkRequestButton.classList.add('is-loading')
}

const resendActivationLinkResponse = arrayResponse => {
    resendActivationLinkRequestButton.classList.remove('is-loading')
    if (arrayResponse['success']) {
        utils.closeModal('signin')
        utils.notifyUser("success", "An email with the activation link has been sent")
    }  else if (arrayResponse['error']) {
        utils.notifyUser("error", utils.errorMessages[arrayResponse['error']])
    }
}