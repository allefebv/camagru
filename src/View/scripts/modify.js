import * as utils from './utils.js'

	var mdp_form = document.getElementById('mdp_form');
	var username_form = document.getElementById('username_form');
	var email_form = document.getElementById('email_form');
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
			removeResponseElement();
			if (response['error']) {
				error_paragraph = document.createElement("p");
				error_paragraph.id = "response_element";
				error_message = document.createTextNode(response.error.message);
				error_paragraph.appendChild(error_message);
				future_parent = document.getElementById(id_parent_error);
				future_parent.appendChild(error_paragraph);
			} else if (response['success']) {
				if (id_new) {
					document.getElementById(id_new).value = "";
				}
				form.style.display = 'none';
				success_paragraph = document.createElement("div");
				success_paragraph.className = "container has-background-black has-text-white";
				success_paragraph.id = "response_element";
				success_message = document.createTextNode(response.success.message);
				success_paragraph.appendChild(success_message);
				future_parent = document.getElementById('content');
				future_parent.appendChild(success_paragraph);
			}
	}


	const username_request_button = document.getElementById('username_request')
	username_request_button.onclick = () => {
		var new_username = document.getElementById('new_username').value;
		var password = document.getElementById('username_password').value;
		utils.ajaxify(
			JSON.stringify({ username:1, new_username:new_username, password:password }),
			usernameResponse,
			'index.php?url=modify'
		);
	}

	function usernameResponse(response) {
		response(
			'username_password',
			'username_password_field',
			'new_username',
			username_form,
			response,
		)
	}


	const email_request_button = document.getElementById('email_request')
	email_request_button.onclick = () => {
		new_email = document.getElementById('new_email').value;
		password = document.getElementById('email_password').value;
		utils.ajaxify(
			JSON.stringify({ email:1, new_email:new_email, password:password }),
			emailResponse,
			'index.php?url=modify'
			);
	}

	function emailResponse(response) {
		response(
			'email_password',
			'email_password_field',
			'new_email',
			email_form,
			response
		)
	}	


	const password_request_button = document.getElementById('password_request')
	password_request_button.onclick = () => {
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






	function displayHide(toDisplay) {
		username_form.style.display = 'none';
		mdp_form.style.display = 'none';
		email_form.style.display = 'none';
		delete_form.style.display = 'none'
		toDisplay.style.display = '';
	}

	function removeResponseElement() {
		var response_element = document.getElementById('response_element')
		if (response_element) {
			response_element.remove();
		}
	}

	const items = document.getElementsByClassName('select-choice')
	Array.prototype.forEach.call(items, function(item) {
		item.addEventListener("click", function() {
			displayHide(eval(item.id.substr(0, item.id.indexOf('_')) + '_' + 'form'))
			removeResponseElement()
		})
	})