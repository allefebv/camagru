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
		<div id="currentPasswordField" class="field">
			<label class="label">Mot de passe actuel</label>
			<div class="control">
				<input id="currentPassword" class="input" type="text">
			</div>
		</div>
		<div class="field">
			<label class="label">Nouveau mot de passe</label>
			<div class="control">
				<input id="newPassword1" class="input" type="text">
			</div>
		</div>
		<div id="newPasswordField" class="field">
			<label class="label">Confirmation nouveau mdp</label>
			<div class="control">
				<input id="newPassword2" class="input" type="text">
			</div>
		</div>
		<button class="button is-light" onclick="passwordRequest()">Modifier</button>
	</div>

	<div id="username_form" style="display:none;">
		<label class="label">MODIFIER LE USERNAME</label>
		<div class="field">
			<label class="label">Nouveau nom utilisateur</label>
			<div class="control">
				<input id="newUsername" class="input" type="text">
			</div>
		</div>
		<div id="usernamePasswordField" class="field">
			<label class="label">Mot de passe pour validation</label>
			<div class="control">
				<input id="usernamePassword" class="input" type="text">
			</div>
		</div>
		<button class="button is-light" onclick=usernameRequest()>Modifier</button>
	</div>

	<div id="email_form" style="display:none;">
		<label class="label">MODIFIER L'EMAIL</label>
		<div class="field">
			<label class="label">Nouvel email</label>
			<div class="control">
				<input id="newEmail" class="input" type="text">
			</div>
		</div>
		<div id="emailPasswordField" class="field">
			<label class="label">Mot de passe pour validation</label>
			<div class="control">
				<input id="emailPassword" class="input" type="text">
			</div>
		</div>
		<button class="button is-light" onclick="emailRequest()">Modifier</button>
	</div>

	<div id="delete_form" style="display:none;">
		<div id="deletePasswordField" class="field">
			<label class="label">Mot de passe pour validation</label>
			<div class="control">
				<input id="deletePassword" class="input" type="text">
			</div>
		</div>
		<button class="button is-light" onclick="deleteRequest()">Confirmer</button>
	</div>


</div>

<script>

	var mdpForm = document.getElementById('mdp_form');
	var usernameForm = document.getElementById('username_form');
	var emailForm = document.getElementById('email_form');
	var deleteForm = document.getElementById('delete_form');

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
						if ('email' in obj) {
							emailResponse(jsonString, obj);
						}
						else if ('username' in obj) {
							console.log('toto');
							usernameResponse(jsonString, obj);
						}
						else if ('password' in obj) {
							passwordResponse(jsonString, obj);
						}
						else if ('delete' in obj) {
							deleteResponse(jsonString, obj);
						}
					}
				}
			}
		}
		httpRequest.open('POST', 'index.php?url=modify', true);
		httpRequest.setRequestHeader('Content-Type', 'multipart/form-data');
		httpRequest.send(jsonString);
	}






	function emailRequest() {
		newEmail = document.getElementById('newEmail').value;
		password = document.getElementById('emailPassword').value;
		ajaxify(JSON.stringify({ email:1, newEmail:newEmail, passwordEmail:password }));
	}

	function emailResponse(jsonRequest, arrayResponse) {
		document.getElementById('emailPassword').value = "";
		removeResponseElement();
		if (arrayResponse['errorPassword']) {
			errorParagraph = document.createElement("p");
			errorParagraph.id = "ResponseElement";
			errorMessage = document.createTextNode("Mot de passe erroné");
			errorParagraph.appendChild(errorMessage);
			futureParent = document.getElementById('emailPasswordField');
			futureParent.appendChild(errorParagraph);
		}
		else if (arrayResponse['success']) {
			console.log('test');
			document.getElementById('newEmail').value = "";
			emailForm.style.display = 'none';
			successParagraph = document.createElement("div");
			successParagraph.className = "container has-background-black has-text-white";
			successParagraph.id = "ResponseElement";
			successMessage = document.createTextNode("Votre email a bien ete modifie");
			successParagraph.appendChild(successMessage);
			futureParent = document.getElementById('content');
			futureParent.appendChild(successParagraph);
		}
	}







	function usernameRequest() {
		newUsername = document.getElementById('newUsername').value;
		password = document.getElementById('usernamePassword').value;
		ajaxify(JSON.stringify({ username:1, newUsername:newUsername, passwordUsername:password }));
	}

	function usernameResponse(jsonRequest, arrayResponse) {
		document.getElementById('usernamePassword').value = "";
		removeResponseElement();
		if (arrayResponse['errorPassword']) {
			errorParagraph = document.createElement("p");
			errorParagraph.id = "ResponseElement";
			errorMessage = document.createTextNode("Mot de passe erroné");
			errorParagraph.appendChild(errorMessage);
			futureParent = document.getElementById('usernamePasswordField');
			futureParent.appendChild(errorParagraph);
		}
		else if (arrayResponse['success']) {
			document.getElementById('newUsername').value = "";
			usernameForm.style.display = 'none';
			successParagraph = document.createElement("div");
			successParagraph.className = "container has-background-black has-text-white";
			successParagraph.id = "ResponseElement";
			successMessage = document.createTextNode("Votre username a bien ete modifie");
			successParagraph.appendChild(successMessage);
			futureParent = document.getElementById('content');
			futureParent.appendChild(successParagraph);
		}
	}









	function passwordRequest() {
		currentPassword = document.getElementById('currentPassword').value;
		newPassword1 = document.getElementById('newPassword1').value;
		newPassword2 = document.getElementById('newPassword2').value;
		ajaxify(JSON.stringify({ password:1,
								newPassword1:newPassword1,
								newPassword2:newPassword2,
								currentPassword:currentPassword }));
	}

	function passwordResponse(jsonRequest, arrayResponse) {
		document.getElementById('currentPassword').value = "";
		document.getElementById('newPassword1').value = "";
		document.getElementById('newPassword2').value = "";
		removeResponseElement();
		if (arrayResponse['errorCurrentPassword'] || arrayResponse['errorNewPassword']) {
			errorParagraph = document.createElement("p");
			errorParagraph.id = "ResponseElement";
			if (arrayResponse['errorCurrentPassword']) {
				console.log('test');
				errorMessage = document.createTextNode("Mot de passe actuel erroné");
				futureParent = document.getElementById('currentPasswordField');
			}
			else {
				errorMessage = document.createTextNode("Les deux champs ne correspondent pas");
				futureParent = document.getElementById('newPasswordField');
			}
			errorParagraph.appendChild(errorMessage);
			futureParent.appendChild(errorParagraph);
		}
		else if (arrayResponse['success']) {
			mdpForm.style.display = 'none';
			successParagraph = document.createElement("div");
			successParagraph.className = "container has-background-black has-text-white";
			successParagraph.id = "ResponseElement";
			successMessage = document.createTextNode("Votre mot de passe a bien ete modifie");
			successParagraph.appendChild(successMessage);
			futureParent = document.getElementById('content');
			futureParent.appendChild(successParagraph);
		}
	}





	function deleteRequest() {
		password = document.getElementById('deletePassword').value;
		ajaxify(JSON.stringify({ delete:1, passwordDelete:password }));
	}

	function deleteResponse(jsonRequest, arrayResponse) {
		document.getElementById('deletePassword').value = "";
		removeResponseElement();
		if (arrayResponse['errorPassword']) {
			errorParagraph = document.createElement("p");
			errorParagraph.id = "ResponseElement";
			errorMessage = document.createTextNode("Mot de passe erroné");
			errorParagraph.appendChild(errorMessage);
			futureParent = document.getElementById('deletePasswordField');
			futureParent.appendChild(errorParagraph);
		}
		else if (arrayResponse['success']) {
			deleteForm.style.display = 'none';
			document.getElementById('account_options').style.display = 'none';
			successParagraph = document.createElement("div");
			successParagraph.className = "container has-background-black has-text-white";
			successParagraph.id = "ResponseElement";
			successMessage = document.createTextNode("Votre compte a bien ete supprime");
			successParagraph.appendChild(successMessage);
			futureParent = document.getElementById('content');
			futureParent.appendChild(successParagraph);
			setTimeout(function() {
				document.location.reload(true);
			}, 2000);
		}
	}







	function displayHide(toDisplay) {
		usernameForm.style.display = 'none';
		mdpForm.style.display = 'none';
		emailForm.style.display = 'none';
		deleteForm.style.display = 'none'
		toDisplay.style.display = '';
	}

	function removeResponseElement() {
		if (responseElement = document.getElementById('ResponseElement')) {
			responseElement.remove();
		}
	}

	document.getElementById('mdp_button').addEventListener("click", function() {
		displayHide(mdpForm);
		removeResponseElement();
	});

	document.getElementById('email_button').addEventListener("click", function() {
		displayHide(emailForm);
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
