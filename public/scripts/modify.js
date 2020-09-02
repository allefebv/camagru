import * as utils from './utils.js'

document.addEventListener('DOMContentLoaded', () => {
    getInfo()
});

	const getInfo = () => {
		utils.ajaxify(
			JSON.stringify({
				getInfo:1
			}),
			getInfoResponse,
			'index.php?url=modify'
		)
	}

	const getInfoResponse = (arrayResponse) => {
		document.getElementById('username-info').value = arrayResponse['username']
		document.getElementById('email-info').value = arrayResponse['email']
		document.getElementById('notification-info').checked = arrayResponse['notifications']
	}

	const setInfoRequestButton = document.getElementById('modify_info_request')
	setInfoRequestButton.onclick = () => {
		let email = document.getElementById('email-info').value
		let username = document.getElementById('username-info').value
		let notification = document.getElementById('notification-info').checked
		utils.ajaxify(
			JSON.stringify({
				setInfo:1,
				email:email,
				username:username,
				notification:notification
			}),
			modifyInfoResponse,
			'index.php?url=modify'
		)
	}

	const modifyInfoResponse = arrayResponse => {
		console.log(arrayResponse)
		for (let responseElement of arrayResponse) {
			if (responseElement['success']) {
				utils.notifyUser("success", utils.successMessages[responseElement['success']])
			}
			if (responseElement['error']) {
				utils.notifyUser("error", utils.errorMessages[responseElement['error']])
			}
		}
		getInfo()
	}


	var mdp_form = document.getElementById('mdp_form');
	var delete_form = document.getElementById('delete_form');

	const modify_password_request_button = document.getElementById('modify_password_request')
	modify_password_request_button.onclick = () => {
		let new_password1 = document.getElementById('new_password1').value;
		let new_password2 = document.getElementById('new_password2').value;
		utils.ajaxify(
			JSON.stringify({
				modifyPassword:1,
				new_password1:new_password1,
				new_password2:new_password2
			}),
			passwordResponse,
			'index.php?url=modify'
		);
	}

	function passwordResponse(response) {
		if (response['success']) {
			utils.notifyUser("success", utils.successMessages[response['success']])
			utils.closeModal('password')
			document.getElementById('new_password1').value = '';
			document.getElementById('new_password2').value = '';
		}
		if (response['error']) {
			utils.notifyUser("error", utils.errorMessages[response['error']])
		}
	}

	const delete_request_button = document.getElementById('delete_request')
	delete_request_button.onclick = () => {
		let deletePassword = document.getElementById('delete-password').value;
		utils.ajaxify(
			JSON.stringify({ delete:1, password:deletePassword }),
			deleteResponse,
			'index.php?url=modify'
			);
	}

	function deleteResponse(response) {
		if (response['success']) {
			utils.notifyUser("success", utils.successMessages[response['success']])
			utils.closeModal('delete')
			document.getElementById('delete-password').value = '';
			setTimeout(function() {
				document.location.reload(true);
			}, 3000);
		}
		if (response['error']) {
			utils.notifyUser("error", utils.errorMessages[response['error']])
		}
	}