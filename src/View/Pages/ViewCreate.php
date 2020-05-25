<?php $this->_title = 'Creation'; ?>
<form action="index.php?url=create" method="POST">
	<div class="field">
		<label class="label">Identifiant</label>
		<div class="control">
			<input name="username" class="input" type="text" placeholder="peepoodo">
		</div>
		<?php if (isset($data) && true === $data['invalid_username']): ?>
			<p class="help is-failure">Invalid Username</p>
		<?php endif; ?>
		<?php if (isset($data) && true === $data['duplicate_username']): ?>
			<p class="help is-failure">This Username is not available</p>
		<?php endif; ?>
	</div>
	<div class="field">
		<label class="label">Mot de passe</label>
		<div class="control">
			<input name="password" class="input" type="text" placeholder="@MyStrong?Password1">
		</div>
		<?php if (isset($data) && true === $data['invalid_pwd']): ?>
			<p class="help is-failure">Password must contain 8 characters, one uppercase, one lowercase, one symbol [@?!*] and one digit</p>
		<?php endif; ?>
	</div>
	<div class="field">
		<label class="label">Email</label>
		<div class="control">
			<input name="email" class="input" type="text" placeholder="peepoodo@forest.com">
		</div>
		<?php if (isset($data) && true === $data['invalid_email']): ?>
			<p class="help is-failure">Invalid Email</p>
		<?php endif; ?>
		<?php if (isset($data) && true === $data['duplicate_email']): ?>
			<p class="help is-failure">An account has already be created under this email address</p>
		<?php endif; ?>
	</div>
	<input type="submit" class="button is-link" value="Valider">
</form>

<p class="content is-medium has-text-warning">
		Vous allez recevoir un email de confirmation pour activer votre compte.<br/>
		Il vous faudra l'activer pour pouvoir vous connecter.
</p>
<form action="index.php?url=activate" method="GET">
	<input type="hidden" name="url" value="create">
	<input class="button is-light" type="submit" value="Renvoyer l'email d'activation"/>
</form>