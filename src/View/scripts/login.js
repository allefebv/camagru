var loginForm = document.getElementById('loginForm');

function ajaxify(jsonString) {
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === 4 && httpRequest.status !== 200) {
            console.log('error return requete serveur');
            document.write(httpRequest.status);
            return false;
        }
        else if (httpRequest.readyState === 4 && httpRequest.status === 200) {
            var httpResponse = httpRequest.response;
            if (httpResponse) {
                var obj = JSON.parse(httpRequest.response);
                if (obj) {
                    loginResponse(jsonString, obj);
                }
            }
        }
    }
    httpRequest.open('POST', 'index.php?url=login', true);
    httpRequest.setRequestHeader('Content-Type', 'multipart/form-data');
    httpRequest.send(jsonString);
}

function loginRequest() {
    email = document.getElementById('email').value;
    password = document.getElementById('password').value;
    ajaxify(JSON.stringify({ email:email, password:password }));
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

function loginResponse(jsonString, arrayResponse) {
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
