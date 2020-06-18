<nav class="navbar has-background-primary" role="navigation" aria-label="main navigation">
	<div class="navbar-brand">
		<a class="navbar-item button" href="index.php">
			<img src="../public/tabicon.ico" height=100%>
		</a>
		<a id="myBurger" role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navMenu">
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
		</a>
  	</div>
	<div id="navMenu" class="navbar-menu">
		<div class="navbar-start">
			<?php if (isset($_SESSION['logged'])): ?>
				<div class="navbar-item">
					<form action="index.php" method="GET">
						<input type="hidden" name="url" value="editor">
						<input class="button is-light" type="submit" value="Editeur"/>
					</form>
				</div>
			<?php endif;?>
		</div>
		<div class="navbar-end">
			<?php if (isset($_SESSION['logged'])): ?>
				<div class="navbar-item">
					<form action="index.php" method="GET">
						<input type="hidden" name="url" value="modify">
						<input class="button is-light" type="submit" value="Modifier mon compte"/>
					</form>
				</div>
				<div class="navbar-item">
					<form action="index.php" method="GET">
						<input type="hidden" name="url" value="logout">
						<input class="button is-light" type="submit" value="Déconnexion"/>
					</form>
				</div>
			<?php else:?>
				<div class="navbar-item">
					<form action="index.php" method="GET">
						<input type="hidden" name="url" value="login">
						<input class="button is-light" type="submit" value="Connexion"/>
					</form>
				</div>
				<div class="navbar-item">
					<form action="index.php?url=account" method="GET">
						<input type="hidden" name="url" value="create">
						<input class="button is-light" type="submit" value="Créer un compte"/>
					</form>
				</div>
			<?php endif;?>
		</div>
	</div>
</nav>

<script type="text/javascript" src="/src/View/scripts/header.js"></script>
