<h1 class="hero has-background-black">Hello ! <?= $_SESSION['logged'] ?></h1>

<?if (isset($_SESSION['logged'])): ?>
	<form action="index.php?url=auth" name="logout" method="POST">
		<input type="submit" name="logout" value="Logout"/>
	</form>
<?else:?>
	<form action="index.php?url=account" name="login" method="POST">
		<input type="submit" name="login" value="Login"/>
	</form>
	<form action="index.php?url=account" name="create" method="POST">
		<input type="submit" name="create" value="Create Account"/>
	</form>
<?endif;?>
