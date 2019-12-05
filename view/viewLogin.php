<?php $this->_title = 'Connexion'; ?>
<form action="index.php?url=login" method="POST">
	<div class="field">
		<label class="label">Identifiant</label>
		<div class="control">
			<input name="username" class="input" type="text" placeholder="exemple : peepoodo">
		</div>
		<?php if ($error === 'username'): ?>
			<p class="help is-failure">Invalid Username</p>
		<?php endif; ?>
	</div>
	<div class="field">
		<label class="label">Mot de passe</label>
		<div class="control">
			<input name="password" class="input" type="text" placeholder="exemple : C4rty%5$">
		</div>
		<?php if($error === 'password'):?>
			<p class="help is-failure">Invalid Password</p>
		<?php endif; ?>
	</div>
	<input type="submit" class="button is-link" value="Valider">
</form>
