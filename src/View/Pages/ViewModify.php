<?php $this->_title = 'Modif Compte'; ?>
<h1 class="title">My Account</h1>
<div class="columns">
	<div class="column is-one-quarter"></div>
	<div class="column is-one-quarter">
		<h2 class="title">My information</h2>
		<div class="field">
			<label class="label">Username</label>
			<div class="control">
				<input id="username-info" class="input" type="text" placeholder="Text input">
			</div>
		</div>
		<div class="field">
			<label class="label">Email</label>
			<div class="control">
				<input id="email-info" class="input" type="text" placeholder="Text input">
			</div>
		</div>
		<div class="field">
			<label class="checkbox">
				<input id="notification-info" type="checkbox" checked>
				Get notified when my images are commented
			</label>
		</div>
		<button class="button" id="modify_info_request">Submit</button>
	</div>
	<div class="column is-one-quarter">
		<h2 class="title">Account actions</h2>
		<button data-bulma-modal-open="password" class="button">Change Password</button>
		<button data-bulma-modal-open="delete" class="button is-danger">Delete my account</button>
	</div>
	<div class="column is-one-quarter"></div>
</div>

<div class="modal" id="modal-delete">
	<div class="modal-background" data-bulma-modal="close"></div>
	<div class="modal-content" id="modal-delete-content">
    	<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Delete Account</p>
				<button class="delete" aria-label="close" data-bulma-modal="close"></button>
			</header>
			<div id="delete-form">
				<section class="mocal-card-body">
					<label class="label">Your password is required for this action</label>
					<input id="delete-password" class="input" type="password" placeholder="Password">
				</section>
				<footer class="modal-card-foot">
					<button class="button" id="delete_request">Delete my account</button>
				</footer>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-password">
	<div class="modal-background" data-bulma-modal="close"></div>
	<div class="modal-content" id="modal-delete-content">
    	<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Modify Password</p>
				<button class="delete" aria-label="close" data-bulma-modal="close"></button>
			</header>
			<div id="password-form">
				<section class="mocal-card-body">
				<div class="new_password_1_field">
				<label class="label">new password</label>
				<div class="control">
					<input name="new_password1" id="new_password1" class="input" type="text">
				</div>
			</div>
			<div id="new_password_2_field" class="field">
				<label class="label">confirm new password</label>
				<div class="control">
					<input name="new_password2" id="new_password2" class="input" type="text">
				</div>
			</div>
				</section>
				<footer class="modal-card-foot">
					<button class="button" id="modify_password_request">Submit</button>
				</footer>
			</div>
		</div>
	</div>
</div>

<script type="module" src="/public/scripts/modify.js"></script>
