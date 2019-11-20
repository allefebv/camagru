<form action="index.php?url=auth" method="POST">
	Identifiant: <input type="text" name="username"/>
	<br />
	Mot de passe: <input type="password" name="password"/>
	<br />
	<input type="submit" value="OK">
	<?php if ($error === 'username'): ?>
		<p>Invalid Username</p>
	<?php else:?>
		<p>Invalid Password</p>
	<?php endif; ?>
</form>
