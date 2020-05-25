<?php $this->_title = 'Modif Compte'; ?>
<div id="account_options" class="container has-background-primary">
	<div class="columns is-centered">
		<div class="column is-5">
			<div style="container">
				<h1 class="title has-text-white">Gestion du compte</h1>
				<nav class="level">
					<div class="level-item">
						<button id="mdp_button" class="button">Mot de passe</button>
					</div>
					<div class="level-item">
						<button id="email_button" class="button">Email</button>
					</div>
					<div class="level-item">
						<button id="username_button" class="button">Username</button>
					</div>
					<div class="level-item">
						<button id="delete_account_button" class="button is-danger">Supprimer mon compte</button>
					</div>
				</nav>
			</div>
		</div>
	</div>
</div>
<div class="container has-background-danger">

	<div id="mdp_form" style="display:none;">
		<label class="label">MODIFIER LE MDP</label>
		<div id="current_password_field" class="field">
			<label class="label">Mot de passe actuel</label>
			<div class="control">
				<input name="current_password" id="current_password" class="input" type="text">
			</div>
		</div>
		<div class="new_password_1_field">
			<label class="label">Nouveau mot de passe</label>
			<div class="control">
				<input name="new_password1" id="new_password1" class="input" type="text">
			</div>
		</div>
		<div id="new_password_2_field" class="field">
			<label class="label">Confirmation nouveau mdp</label>
			<div class="control">
				<input name="new_password2" id="new_password2" class="input" type="text">
			</div>
		</div>
		<button class="button is-light" onclick="passwordRequest()">Modifier</button>
	</div>

	<div id="username_form" style="display:none;">
		<label class="label">MODIFIER LE USERNAME</label>
		<div class="field">
			<label class="label">Nouveau nom utilisateur</label>
			<div class="control">
				<input name="new_username" id="new_username" class="input" type="text">
			</div>
		</div>
		<div id="username_password_field" class="field">
			<label class="label">Mot de passe pour validation</label>
			<div class="control">
				<input name="password" id="username_password" class="input" type="text">
			</div>
		</div>
		<button class="button is-light" onclick=usernameRequest()>Modifier</button>
	</div>

	<div id="email_form" style="display:none;">
		<label class="label">MODIFIER L'EMAIL</label>
		<div class="field">
			<label class="label">Nouvel email</label>
			<div class="control">
				<input name="new_email" id="new_email" class="input" type="text">
			</div>
		</div>
		<div id="email_password_field" class="field">
			<label class="label">Mot de passe pour validation</label>
			<div class="control">
				<input name="password" id="email_password" class="input" type="text">
			</div>
		</div>
		<button class="button is-light" onclick="emailRequest()">Modifier</button>
	</div>

	<div id="delete_form" style="display:none;">
		<div id="delete_password_field" class="field">
			<label class="label">Mot de passe pour validation</label>
			<div class="control">
				<input name="password" id="delete_password" class="input" type="text">
			</div>
		</div>
		<button class="button is-light" onclick="deleteRequest()">Confirmer</button>
	</div>


</div>

<script>

	var mdp_form = document.getElementById('mdp_form');
	var usernameForm = document.getElementById('username_form');
	var email_form = document.getElementById('email_form');
	var deleteForm = document.getElementById('delete_form');

	function ajaxify(json_string) {
		var http_request = new XMLHttpRequest();
		http_request.onreadystatechange = function() {
			if (http_request.readyState === 4 && http_request.status !== 200) {
				console.log('error return requete serveur');
				document.write(http_request.status);
				return false;
			}
			else if (http_request.readyState === 4 && http_request.status === 200) {
				var httpResponse = http_request.response;
				if (httpResponse) {
					var obj = JSON.parse(http_request.response);
					if (obj) {
						if ('email' in obj) {
							emailResponse(json_string, obj);
						}
						else if ('username' in obj) {
							usernameResponse(json_string, obj);
						}
						else if ('password' in obj) {
							passwordResponse(json_string, obj);
						}
						else if ('delete' in obj) {
							deleteResponse(json_string, obj);
						}
					}
				}
			}
		}
		http_request.open('POST', 'index.php?url=modify', true);
		http_request.setRequestHeader('Content-Type', 'multipart/form-data');
		http_request.send(json_string);
	}






	function emailRequest() {
		new_email = document.getElementById('new_email').value;
		password = document.getElementById('email_password').value;
		ajaxify(JSON.stringify({ email:1, new_email:new_email, password:password }));
	}

	function emailResponse(json_request, array_response) {
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







	function usernameRequest() {
		new_username = document.getElementById('new_username').value;
		password = document.getElementById('username_password').value;
		ajaxify(JSON.stringify({ username:1, new_username:new_username, password:password }));
	}

	function usernameResponse(json_request, array_response) {
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
			usernameForm.style.display = 'none';
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
		ajaxify(JSON.stringify({
				password:1,
				new_password1:new_password1,
				new_password2:new_password2,
				current_password:current_password
		}));
	}

	function passwordResponse(json_request, array_response) {
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
		ajaxify(JSON.stringify({ delete:1, password:password }));
	}

	function deleteResponse(json_request, array_response) {
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
			deleteForm.style.display = 'none';
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
		usernameForm.style.display = 'none';
		mdp_form.style.display = 'none';
		email_form.style.display = 'none';
		deleteForm.style.display = 'none'
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
		displayHide(usernameForm);
		removeResponseElement();
	});

	document.getElementById('delete_account_button').addEventListener("click", function() {
		displayHide(deleteForm);
		removeResponseElement();
	});

</script>
