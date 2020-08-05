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
						<input type="hidden" name="url" value="logout">
						<input class="button is-light" type="submit" value="Log out"/>
					</form>
				</div>
				<div class="navbar-item">
					<form action="index.php" method="GET">
						<input type="hidden" name="url" value="modify">
						<input class="button is-light" type="submit" value="<?php echo $_SESSION['username'] ?>"/>
					</form>
				</div>
			<?php else:?>
				<div class="navbar-item">
					<button class="button is-light" id="button-login">Sign In</button>
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

<div class="modal" id="modal-login">
	<div class="modal-background" data-bulma-modal="close"></div>
	<div class="modal-content" id="modal-login-content">
    	<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Sign In</p>
				<button class="delete" aria-label="close" data-bulma-modal="close"></button>
			</header>
			<div id="login-form">
				<section class="mocal-card-body">
					<input id="email" class="input" type="text" placeholder="Email">
					<input id="password" class="input" type="password" placeholder="Password">
				</section>
				<footer class="modal-card-foot">
					<button class="button is-success" id="login_request">Sign in</button>
					<form action="index.php" method="GET">
						<input type="hidden" name="url" value="password">
						<input class="button" type="submit" value="Forgot Password"/>
					</form>
				</footer>
			</div>
		</div>
	</div>
</div>

<script type="module" src="/public/scripts/header.js"></script>
<script type="module" src="/public/scripts/login.js"></script>
