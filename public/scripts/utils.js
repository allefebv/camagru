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

export const POST_METHOD = "POST";

const TIMEOUT = 5000;

export function fetchApi(url, args) {
	return new Promise((resolve, reject) => {
		setTimeout(() => {
			reject(new Error("timeout"));
		}, TIMEOUT);

		if (
			args.body &&
			args.headers &&
			args.headers["Content-Type"] &&
			args.headers["Content-Type"] === "application/json"
		) {
			args.body = JSON.stringify(args.body);
		}

		fetch(url, args)
			.then((response) => {
				if (!response.ok) {
					reject(new Error(response.statusText));
				}
				return response;
			})
			.then((response) => {
                if (response.headers.get("Content-type") === 'application/json') {
					resolve(response.json());
                } else {
                    resolve();
                }
			});
	});
}

export function ajaxify(jsonString, callback, route) {
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === 4 && httpRequest.status !== 200) {
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
        sessionStorage.setItem('logged', true);
    } else {
        sessionStorage.setItem('logged', false);
    }
}

export function getConnexionStatus() {
    return fetchApi('index.php', {
        method: POST_METHOD,
        headers: {
            "Content-Type": "application/json",
        },
        body: { connexionStatus:1 },
    }).then((response) => {
        successConnexionStatus(response);
    });
}

export function createElement(type = div, innerHTML = null, classList = null, id = null, parentId = null) {
    let element = document.createElement(type);
    for (let className of classList) {
        element.classList.add(className);
    }
    if (innerHTML !== null) {
        element.innerHTML = innerHTML;
    }
    if (id) {
        element.id = id;
    }
    if (parentId) {
        let parent = document.getElementById(parentId);
        parent.appendChild(element);
    }
    return element;
}