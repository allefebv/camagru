<nav class="navbar has-background-dark main-navbar is-fixed-top" role="navigation" aria-label="main navigation">
	<div class="navbar-brand">
		<a class="navbar-item" href="index.php">
			<img src="../public/camagru.png">
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
					<button class="button is-light" data-bulma-modal-open="signin">Sign In</button>
				</div>
				<div class="navbar-item">
					<button class="button is-light" data-bulma-modal-open="signup">Sign Up</button>
				</div>
			<?php endif;?>
		</div>
	</div>
</nav>

<div class="modal" id="modal-signin">
	<div class="modal-background" data-bulma-modal="close"></div>
	<div class="modal-content" id="modal-signin-content">
    	<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Sign In</p>
				<button class="delete" aria-label="close" data-bulma-modal="close"></button>
			</header>
			<div id="signin-form">
				<section class="mocal-card-body">
					<input id="signin-email" class="input" type="text" placeholder="Email">
					<input id="signin-password" class="input" type="password" placeholder="Password">
				</section>
				<footer class="modal-card-foot">
					<button class="button is-success" id="signin-request">Sign in</button>
					<button class="button is-warning" id="forgot-password-request">Forgot Password</button>
					<button class="button is-warning" id="resend-activation-link-request">Resend Activation Link</button>
				</footer>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-signup">
	<div class="modal-background" data-bulma-modal="close"></div>
	<div class="modal-content" id="modal-signup-content">
    	<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Sign Up</p>
				<button class="delete" aria-label="close" data-bulma-modal="close"></button>
			</header>
			<div id="signup-form">
				<section class="mocal-card-body">
					<input id="signup-username" class="input" type="text" placeholder="Username">
					<input id="signup-email" class="input" type="text" placeholder="Email">
					<input id="signup-password" class="input" type="password" placeholder="Password">
					<input id="signup-password-confirm" class="input" type="password" placeholder="Confirm Password">
				</section>
				<footer class="modal-card-foot">
					<button class="button is-success" id="signup_request">Sign up</button>
				</footer>
			</div>
		</div>
	</div>
</div>

<script type="module" src="/public/scripts/header.js"></script>
<script type="module" src="/public/scripts/signin.js"></script>
<script type="module" src="/public/scripts/signup.js"></script>
