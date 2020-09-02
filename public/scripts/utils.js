export const errorMessages = {
    "invalid_pwd" : "Password must contain 8 characters, one uppercase, one lowercase, one symbol of @?!* and one digit",
    "invalid_email" : "Your Email in invalid",
    "not_found_email" : "No account is linked to this email",
    "non_matching_pwds" : "The two password you typed are not identical",
    "duplicate_username" : "Sorry, this username is already in use",
    "duplicate_email" : "Sorry, there is already an account registered with this email",
    "incorrect_email" : "Sorry, there is no account linked to this email",
    "inactive_account" : "Your account is inactive, please click the link in your inbox",
    "incorrect_pwd" : "Incorrect Password",
    "database_error" : "There has been a server internal error",
}

export const successMessages = {
    "updated_username" : "Your username has been successfuly updated",
    "updated_email" : "Your email has been successfuly updated",
    "updated_notifications" : "Your notifications preferences have been successfuly updated",
    "updated_password" : "Your password has been updated",
    "account_deleted" : "Your account has been deleted",
}

export function ajaxify(jsonString, callback, route) {
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === 4 && httpRequest.status !== 200) {
            console.log('error return requete serveur')
            document.write(httpRequest.status)
            return false
        }
        else if (httpRequest.readyState === 4 && httpRequest.status === 200) {
            var httpResponse = httpRequest.response
            if (httpResponse) {
                var obj = JSON.parse(httpRequest.response)
                if (obj) {
                    callback(obj)
                }
            }
        }
    }
    httpRequest.open('POST', route, true)
    httpRequest.setRequestHeader('Content-Type', 'multipart/form-data')
    httpRequest.send(jsonString)
}

export function notifyUser(status, message) {
    var notificationList = document.getElementById("notificationList")

    var notification = document.createElement('div')
    notification.classList.add('notification')

    var closeButton = document.createElement('button')
    closeButton.classList.add('delete')

    notification.innerHTML = message
    notification.appendChild(closeButton)
    switch (status) {
        case "success":
            notification.classList.add('is-success')
            break
        case "error":
            notification.classList.add('is-danger')
            break
    }
    notificationList.appendChild(notification)
    setTimeout(() => {
        notification.remove()
    }, 3000);
}

function openModal(modalName) {
    var buttons = document.querySelectorAll('[data-bulma-modal-open=' + modalName + ']')
    var modal = document.getElementById("modal-" + modalName)

    for (var button of buttons) {
        button.onclick = () => {
            modal.classList.add('is-active')
        }
    }
}

export function initOpenModals() {
    let modals = document.getElementsByClassName('modal')
    for (let modal of modals) {
        let strpos = modal.id.indexOf('-') + 1
        openModal(modal.id.slice(strpos))
    }
}

export function initCloseModals() {
    let modalCloseList = document.querySelectorAll("[data-bulma-modal='close']")
    for (var button of modalCloseList) {
        button.addEventListener('click', function() {
            let modals = document.getElementsByClassName('modal')
            for (let modal of modals) {
                modal.classList.remove('is-active')
                if (modal.id === 'modal-image') {
                    modal.innerHTML = ''
                }
            }
        })
    }
}

export function closeModal(modalName) {
    document.getElementById("modal-" + modalName).classList.remove('is-active')
}
    

export function reloadPage(delay = 0) {
    setTimeout(function() {
        document.location.reload(true);
    }, delay);
}

function successConnexionStatus(response) {
    if (response.logged === true) {
        sessionStorage.setItem('logged', true)
    } else {
        sessionStorage.setItem('logged', false)
    }
}

export function getConnexionStatus() {
    ajaxify(
        JSON.stringify({ connexionStatus:1 }),
        successConnexionStatus,
        'index.php'
    )
}

