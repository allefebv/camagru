<?php $this->_title = 'Accueil';?>
<div class="container has-text-centered has-background-primary">
	<?php foreach($images as $image): ?>
		<img src="<?= $image->pathToImage() ?>"/>
		<?php if (isset($_SESSION['logged'])): ?>
			<button class="button likeButton" id="<?= $image->id() ?>" onclick="likeImage(this)">Like</button>
			<textarea name="comment"></textarea>
		<!-- Integrer ici les commentaires + possibilité de commenter -->
		<?php endif; ?>
	<?php endforeach; ?>
</div>

<script>
	var likeButtons = document.getElementsByClassName('likeButton');

	function likeImage(likeButton) {
		var httpRequest = new XMLHttpRequest();

		httpRequest.onreadystatechange = function() {
			if (httpRequest.readyState === 4 && httpRequest.status !== 200) {
				console.log('error return requete serveur');
				document.write(httpRequest.status);
				return false;
			}
		}
		imgId = likeButton.getAttribute('id');
		console.log(imgId);
		httpRequest.open('POST', 'index.php?url=accueil', true);
		httpRequest.setRequestHeader('Content-Type', 'multipart/form-data');
		httpRequest.send(JSON.stringify({ imageIdLike:imgId }));
	};

	// Array.prototype.forEach.call(likeButtons, function(likeButton) {
	// 	likeButton.addEventListener('click', likeImage(likeButton.getAttribute('id')));
	// });
</script>
