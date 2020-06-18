<?php

	use \Camagru\Model\Repositories\UserRepository;

	$userManager = new UserRepository;
	$this->_title = 'Accueil';
?>
<div class="container has-text-centered">
	<?php if (isset($images)): ?>
		<?php foreach($images as $image): ?>
			<div class="columns is-centered">
				<div class="column is-one-third">
					<p class="image is-4by3">
						<img src="<?= $image->pathToImage() ?>"/>
					</p>
					<p id="likes<?= $image->id() ?>" class="is-size-4 has-text-danger has-text-centered has-text-weight-bold">
						<?= $image->likes() ?>
					</p>
					<?php if (isset($_SESSION['logged'])): ?>
						<button class="button" id="like<?= $image->id() ?>" onclick="likeImage(this)">Like</button>
					<?php endif; ?>
				</div>
				<div class="column is-half">
					<?php
						$comments = $image->comments();
						if ($comments):
							foreach($comments as $comment): ?>
								<div class="message">
									<div class="message-header">
										<?php
											$user = $userManager->getUserById($comment->userId())[0];
											echo $user->username();
										?>
									</div>
									<div class="message-body">
										<?= $comment->commentText() ?>
									</div>
								</div>
							<?php endforeach;
						endif; ?>
					<?php if (isset($_SESSION['logged'])): ?>
						<article class="media">
							<div class="media-content">
								<div class="field">
									<p class="control">
										<textarea class="textarea is-small" id="text<?= $image->id() ?>" placeholder="Raconte ta vie..."></textarea>
									</p>
								</div>
								<div class="field">
									<p class="control">
										<button class="button" id="comment<?= $image->id() ?>" onclick="postComment(this)">Post comment</button>
									</p>
								</div>
							</div>
						</article>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	<?php else: ?>
		<div>La Gallerie est vide</div>
	<?php endif; ?>
</div>

<script type="text/javascript" src="/src/View/scripts/accueil.js"></script>
