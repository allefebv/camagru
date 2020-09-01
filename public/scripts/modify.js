import * as utils from './utils.js'

	const modifyInfoRequestButton = document.getElementById('modify_info_request')
	modifyInfoRequestButton.onclick = () => {
		let email = document.getElementById('email-info').value
		let username = document.getElementById('username-info').value
		let notification = document.getElementById('notification-info').checked
		utils.ajaxify(
			JSON.stringify({
				info:1,
				email:email,
				username:username,
				notification:notification
			}),
			modifyInfoResponse,
			'index.php?url=modify'
		)
	}

	const modifyInfoResponse = arrayResponse => {
		if (arrayResponse['success']) {
			for (success of arrayResponse['success']) {
				utils.notifyUser("success", success)
			}
		}

		if (arrayResponse['error']) {
			for (error of arrayResponse['error']) {
				utils.notifyUser("error", error)
			}
		}
	}


	var mdp_form = document.getElementById('mdp_form');
	var delete_form = document.getElementById('delete_form');

	const response = (
		id_password,
		id_parent_error,
		id_new,
		form,
		response
		) => {
			for (let id of id_password) {
				document.getElementById(id).value = "";
			}
	}

	const modify_password_request_button = document.getElementById('modify_password_request')
	modify_password_request_button.onclick = () => {
		current_password = document.getElementById('current_password').value;
		new_password1 = document.getElementById('new_password1').value;
		new_password2 = document.getElementById('new_password2').value;
		utils.ajaxify(
			JSON.stringify({
				password:1,
				new_password1:new_password1,
				new_password2:new_password2,
				current_password:current_password
			}),
			passwordResponse,
			'index.php?url=modify'
		);
	}

	function passwordResponse(response) {
		response(
			['current_password', 'new_password1', 'new_password2'],
			'current_password_field',
			null,
			mdp_form,
			response
		)
	}


	const delete_request_button = document.getElementById('delete_request')
	delete_request_button.onclick = () => {
		delete_password = document.getElementById('delete_password').value;
		utils.ajaxify(
			JSON.stringify({ delete:1, password:password }),
			deleteResponse,
			'index.php?url=modify'
			);
	}

	function deleteResponse(response) {
		response(
			'delete_password',
			'deletePasswordField',
			null,
			delete_form,
			response
		)
		setTimeout(function() {
			document.location.reload(true);
		}, 2000);
	}