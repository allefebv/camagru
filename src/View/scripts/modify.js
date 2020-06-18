import * as utils from './utils.js'

	var mdp_form = document.getElementById('mdp_form');
	var username_form = document.getElementById('username_form');
	var email_form = document.getElementById('email_form');
	var delete_form = document.getElementById('delete_form');

	const response = obj => {
		if ('email' in obj) {
			emailResponse(obj);
		}
		else if ('username' in obj) {
			usernameResponse(obj);
		}
		else if ('password' in obj) {
			passwordResponse(obj);
		}
		else if ('delete' in obj) {
			deleteResponse(obj);
		}
	}

	const username_request_button = document.getElementById('username_request')

	username_request_button.onclick = function usernameRequest() {
		var new_username = document.getElementById('new_username').value;
		var password = document.getElementById('username_password').value;
		utils.ajaxify(
			JSON.stringify({ username:1, new_username:new_username, password:password }),
			response,
			'index.php?url=modify'
		);
	}

	function emailRequest() {
		new_email = document.getElementById('new_email').value;
		password = document.getElementById('email_password').value;
		utils.ajaxify(
			JSON.stringify({ email:1, new_email:new_email, password:password }),
			response,
			'index.php?url=modify'
			);
	}

	function emailResponse(array_response) {
		document.getElementById('email_password').value = "";
		removeResponseElement();
		if (array_response['incorrect_pwd']) {
			error_paragraph = document.createElement("p");
			error_paragraph.id = "response_element";
			error_message = document.createTextNode("Mot de passe erroné");
			error_paragraph.appendChild(error_message);
			future_parent = document.getElementById('email_password_field');
			future_parent.appendChild(error_paragraph);
		}
		else if (array_response['success']) {
			console.log('test');
			document.getElementById('new_email').value = "";
			email_form.style.display = 'none';
			success_paragraph = document.createElement("div");
			success_paragraph.className = "container has-background-black has-text-white";
			success_paragraph.id = "response_element";
			success_message = document.createTextNode("Votre email a bien ete modifie");
			success_paragraph.appendChild(success_message);
			future_parent = document.getElementById('content');
			future_parent.appendChild(success_paragraph);
		}
	}


	function usernameResponse(array_response) {
		document.getElementById('username_password').value = "";
		removeResponseElement();
		if (array_response['incorrect_password']) {
			error_paragraph = document.createElement("p");
			error_paragraph.id = "response_element";
			error_message = document.createTextNode("Mot de passe erroné");
			error_paragraph.appendChild(error_message);
			future_parent = document.getElementById('username_password_field');
			future_parent.appendChild(error_paragraph);
		}
		else if (array_response['success']) {
			document.getElementById('new_username').value = "";
			username_form.style.display = 'none';
			success_paragraph = document.createElement("div");
			success_paragraph.className = "container has-background-black has-text-white";
			success_paragraph.id = "response_element";
			success_message = document.createTextNode("Votre username a bien ete modifie");
			success_paragraph.appendChild(success_message);
			future_parent = document.getElementById('content');
			future_parent.appendChild(success_paragraph);
		}
	}









	function passwordRequest() {
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
			response,
			'index.php?url=modify'
		);
	}

	function passwordResponse(array_response) {
		document.getElementById('current_password').value = "";
		document.getElementById('new_password1').value = "";
		document.getElementById('new_password2').value = "";
		removeResponseElement();
		if (array_response['error_current_pwd']
			|| array_response['error_format_new_pwd']
			|| array_response['error_diff_new_pwd']) {
			error_paragraph = document.createElement("p");
			error_paragraph.id = "response_element";
			if (array_response['error_current_pwd']) {
				console.log('test');
				error_message = document.createTextNode("Mot de passe actuel erroné");
				future_parent = document.getElementById('current_password_field');
			} else if (array_response['error_format_new_pwd']) {
				error_message = document.createTextNode("Password must contain 8 characters, one uppercase, one lowercase, one symbol [@?!*] and one digit");
				future_parent = document.getElementById('new_password_field');
			} else if (array_response['error_diff_new_pwd']) {
				error_message = document.createTextNode("Les deux champs ne correspondent pas");
				future_parent = document.getElementById('new_password_field');
			}
			error_paragraph.appendChild(error_message);
			future_parent.appendChild(error_paragraph);
		}
		else if (array_response['success']) {
			mdp_form.style.display = 'none';
			success_paragraph = document.createElement("div");
			success_paragraph.className = "container has-background-black has-text-white";
			success_paragraph.id = "response_element";
			success_message = document.createTextNode("Votre mot de passe a bien ete modifie");
			success_paragraph.appendChild(success_message);
			future_parent = document.getElementById('content');
			future_parent.appendChild(success_paragraph);
		}
	}





	function deleteRequest() {
		delete_password = document.getElementById('delete_password').value;
		utils.ajaxify(
			JSON.stringify({ delete:1, password:password }),
			response,
			'index.php?url=modify'
			);
	}

	function deleteResponse(array_response) {
		document.getElementById('delete_password').value = "";
		removeResponseElement();
		if (array_response['incorrect_pwd']) {
			error_paragraph = document.createElement("p");
			error_paragraph.id = "response_element";
			error_message = document.createTextNode("Mot de passe erroné");
			error_paragraph.appendChild(error_message);
			future_parent = document.getElementById('deletePasswordField');
			future_parent.appendChild(error_paragraph);
		}
		else if (array_response['success']) {
			delete_form.style.display = 'none';
			document.getElementById('account_options').style.display = 'none';
			success_paragraph = document.createElement("div");
			success_paragraph.className = "container has-background-black has-text-white";
			success_paragraph.id = "response_element";
			success_message = document.createTextNode("Votre compte a bien ete supprime");
			success_paragraph.appendChild(success_message);
			future_parent = document.getElementById('content');
			future_parent.appendChild(success_paragraph);
			setTimeout(function() {
				document.location.reload(true);
			}, 2000);
		}
	}







	function displayHide(toDisplay) {
		username_form.style.display = 'none';
		mdp_form.style.display = 'none';
		email_form.style.display = 'none';
		delete_form.style.display = 'none'
		toDisplay.style.display = '';
	}

	function removeResponseElement() {
		if (response_element = document.getElementById('response_element')) {
			response_element.remove();
		}
	}

	document.getElementById('mdp_button').addEventListener("click", function() {
		displayHide(mdp_form);
		removeResponseElement();
	});

	document.getElementById('email_button').addEventListener("click", function() {
		displayHide(email_form);
		removeResponseElement();
	});

	document.getElementById('username_button').addEventListener("click", function() {
		displayHide(username_form);
		removeResponseElement();
	});

	document.getElementById('delete_account_button').addEventListener("click", function() {
		displayHide(delete_form);
		removeResponseElement();
	});
