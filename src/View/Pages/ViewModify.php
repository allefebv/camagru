<?php $this->_title = 'Modif Compte'; ?>
<div id="account_options" class="container has-background-primary">
	<div class="columns is-centered">
		<div class="column is-5">
			<div style="container">
				<h1 class="title has-text-white">Gestion du compte</h1>
				<nav class="level">
					<div class="level-item">
						<button id="mdp_button" class="button select-choice">Mot de passe</button>
					</div>
					<div class="level-item">
						<button id="email_button" class="button select-choice">Email</button>
					</div>
					<div class="level-item">
						<button id="username_button" class="button select-choice">Username</button>
					</div>
					<div class="level-item">
						<button id="delete_account_button" class="button is-danger select-choice">Supprimer mon compte</button>
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
		<button class="button is-light" id="password_request">Modifier</button>
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
		<button id="username_request" class="button is-light">Modifier</button>
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
		<button class="button is-light" id="email_request">Modifier</button>
	</div>

	<div id="delete_form" style="display:none;">
		<div id="delete_password_field" class="field">
			<label class="label">Mot de passe pour validation</label>
			<div class="control">
				<input name="password" id="delete_password" class="input" type="text">
			</div>
		</div>
		<button class="button is-light" id="delete_request">Confirmer</button>
	</div>


</div>

<script type="module" src="/public/scripts/modify.js"></script>
