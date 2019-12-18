<?php $this->_title = 'Modif Compte'; ?>
<div class="container has-background-primary">
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
				</nav>
			</div>
		</div>
	</div>
</div>
<div class="container has-background-danger">

	<div id="mdp_form" style="display:none;">
		<label class="label">MODIFIER LE MDP</label>
		<div class="field">
			<label class="label">Mot de passe actuel</label>
			<div class="control">
				<input class="input" type="text">
			</div>
		</div>
		<div class="field">
			<label class="label">Nouveau mot de passe</label>
			<div class="control">
				<input class="input" type="text">
			</div>
		</div>
		<div class="field">
			<label class="label">Confirmation nouveau mdp</label>
			<div class="control">
				<input class="input" type="text">
			</div>
		</div>
		<input type="hidden" name="url" value="modify">
		<button class="button is-light" value="Modifier" onclick="passwordRequest()">Modifier</button>
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
		<input type="hidden" name="url" value="modify">
		<button class="button is-light" value="Modifier" onclick=usernameRequest()>Modifier</button>
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
		<input type="hidden" name="url" value="modify">
		<button class="button is-light" value="Modifier" onclick="emailRequest()">Modifier</button>
	</div>
</div>

<script>

	var mdpForm = document.getElementById('mdp_form');
	var usernameForm = document.getElementById('username_form');
	var emailForm = document.getElementById('email_form');

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
							usernameResponse(jsonString, obj);
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
		document.getElementById('newEmail').value = "";
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
		document.getElementById('newUsername').value = "";
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

	}

	function passwordResponse() {

	}

	function removeResponseElement() {
		if (responseElement = document.getElementById('ResponseElement')) {
			responseElement.remove();
		}
	}

	document.getElementById('mdp_button').addEventListener("click", function() {
		usernameForm.style.display = 'none';
		emailForm.style.display = 'none';
		mdpForm.style.display = '';
		removeResponseElement();
	});

	document.getElementById('email_button').addEventListener("click", function() {
		usernameForm.style.display = 'none';
		emailForm.style.display = '';
		mdpForm.style.display = 'none';
		removeResponseElement();
	});

	document.getElementById('username_button').addEventListener("click", function() {
		usernameForm.style.display = '';
		emailForm.style.display = 'none';
		mdpForm.style.display = 'none';
		removeResponseElement();
	});

</script>
