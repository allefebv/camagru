import * as utils from './utils.js'

const signin_request_button = document.getElementById('signin_request')
signin_request_button.onclick = () => {
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
