import * as utils from './utils.js'

var loginForm = document.getElementById('loginForm');

const login_request_button = document.getElementById('login_request')
login_request_button.onclick = () => {
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    utils.ajaxify(
        JSON.stringify({ email:email, password:password }),
        loginResponse,
        'index.php?url=login'
    );
}

const loginResponse = arrayResponse => {
    document.getElementById('password').value = "";
    if (arrayResponse['success']) {
        utils.closeModal('login')
        utils.goToHome()
        utils.notifyUser("success", "Successful Connection")
    }
}
