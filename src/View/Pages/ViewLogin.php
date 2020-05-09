<?php $this->_title = 'Connexion'; ?>

<? if (isset($activated) && $activated === 1): ?>
	<div class="alert">
		Votre compte a bien été activé
	</div>
<? elseif (isset($linkError)): ?>
	<div class="alert">
		Lien d'activation périmé
	</div>
<? endif; ?>

<div id="loginForm">
	<div id="emailField" class="field">
		<label class="label has-text-danger">Email</label>
		<div class="control">
			<input id="email" class="input" type="text" placeholder="exemple : peepoodo@forest.com">
		</div>
	</div>
	<div id="passwordField" class="field">
		<label class="label has-text-danger">Mot de passe</label>
		<div class="control">
			<input id="password" class="input" type="password" placeholder="exemple : C4rty%5$">
		</div>
	</div>
	<button class="button is-success" onclick="loginRequest()">Connexion</button>
	<form action="index.php" method="GET">
		<input type="hidden" name="url" value="password">
		<input class="button is-light" type="submit" value="Mot de passe oublié"/>
	</form>
</div>

<script>

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
		if (arrayResponse['passwordError']) {
			createParagraph('passwordField', 'Mot de passe erroné');
		}
		else if (arrayResponse['emailError']) {
			createParagraph('emailField', 'Email inconnu');
		}
		else if (arrayResponse['success']) {
			loginForm.style.display = 'none';
			createParagraph('content', 'Vous etes connecté');
			setTimeout(function() {
				document.location.reload(true);
			}, 2000);
		}
	}

</script>
