<?php $this->_title = 'Creation'; ?>
<form action="index.php?url=create" method="POST">
	<div class="field">
		<label class="label">Identifiant</label>
		<div class="control">
			<input name="username" class="input" type="text" placeholder="peepoodo">
		</div>
		<?php if ($error === 'username'): ?>
			<p class="help is-failure">Invalid Username</p>
		<?php endif; ?>
	</div>
	<div class="field">
		<label class="label">Mot de passe</label>
		<div class="control">
			<input name="password" class="input" type="text" placeholder="{Str0ng]Example[">
		</div>
		<?php if($error === 'password'):?>
			<p class="help is-failure">Invalid Password</p>
		<?php endif; ?>
	</div>
	<div class="field">
		<label class="label">Email</label>
		<div class="control">
			<input name="email" class="input" type="text" placeholder="peepoodo@forest.com">
		</div>
		<?php if($error === 'password'):?>
			<p class="help is-failure">Invalid Password</p>
		<?php endif; ?>
	</div>
	<input type="submit" class="button is-link" value="Valider">
</form>
