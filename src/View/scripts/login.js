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

function createParagraph(parentNode, message) {
    errorParagraph = document.createElement("p");
    errorParagraph.id = "ResponseElement";
    errorMessage = document.createTextNode(message);
    errorParagraph.appendChild(errorMessage);
    futureParent = document.getElementById(parentNode);
    futureParent.appendChild(errorParagraph);
}

function deleteParagraph () {
    if (responseElement = document.getElementById('ResponseElement')) {
        responseElement.remove();
    }
}

const loginResponse = arrayResponse => {
    document.getElementById('password').value = "";
    deleteParagraph();
    if (arrayResponse['incorrect_pwd']) {
        createParagraph('passwordField', 'Mot de passe erroné');
    } else if (arrayResponse['inactive_account']) {
        createParagraph('inactiveField', 'Vous devez Activer votre compte');
    } else if (arrayResponse['incorrect_email']) {
        createParagraph('emailField', 'Email inconnu');
    } else if (arrayResponse['success']) {
        loginForm.style.display = 'none';
        createParagraph('content', 'Vous etes connecté');
        setTimeout(function() {
            document.location.reload(true);
        }, 2000);
    }
}
