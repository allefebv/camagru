<?php $this->_title = 'Modif Compte'; ?>

<div class="columns is-centered">
	<div class="column is-5">
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

<form id="mdp_form" action="index.php" method="GET" style="display:none;">
	<label class="label">MODIFIER LE MDP</label>
	<div class="field">
		<label class="label">Mot de passe actuel</label>
		<div class="control">
			<p>MDP ACTUEL</p>
		</div>
	</div>
	<input type="hidden" name="url" value="modifyPassword">
	<input class="button is-light" type="submit" value="Modifier"/>
</form>

<form id="username_form" action="index.php" method="GET" style="display:none;">
	<input type="hidden" name="url" value="modifyUsername">
	<input class="button is-light" type="submit" value="Modifier"/>
</form>

<form id="email_form" action="index.php" method="GET" style="display:none;">
	<input type="hidden" name="url" value="modifyEmail">
	<input class="button is-light" type="submit" value="Modifier"/>
</form>

<script>

	var mdpForm = document.getElementById('mdp_form');
	var mdpButton = document.getElementById('mdp_button');
	var usernameForm = document.getElementById('username_form');
	var usernameButton = document.getElementById('username_button');
	var emailForm = document.getElementById('email_form');
	var emailButton = document.getElementById('email_button');

</script>
