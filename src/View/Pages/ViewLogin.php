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
			<input id="email" class="input" type="text" placeholder="peepoodo@forest.com">
		</div>
	</div>
	<div id="passwordField" class="field">
		<label class="label has-text-danger">Mot de passe</label>
		<div class="control">
			<input id="password" class="input" type="password" placeholder="@MyStrong?Password1">
		</div>
	</div>
	<button class="button is-success" onclick="loginRequest()">Connexion</button>
	<form action="index.php" method="GET">
		<input type="hidden" name="url" value="password">
		<input class="button is-light" type="submit" value="Mot de passe oublié"/>
	</form>

	<div id="inactiveField">
	</div>
</div>

<script type="text/javascript" src="/src/View/scripts/login.js"></script>
