<?php $this->_title = 'Accueil';?>
<div class="container has-text-centered has-background-primary">
	<?php foreach($images as $image): ?>
		<img src="<?= $image->pathToImage() ?>"/>
		<?php if (isset($_SESSION['logged'])): ?>
			<button class="button" id="<?= $image->id() ?>" onclick="like()">Like</button>
			<textarea name="comment"></textarea>
		<!-- Integrer ici les commentaires + possibilité de commenter -->
		<?php endif; ?>
	<?php endforeach; ?>
</div>

<script>
	var like = document.getElementByClassName('like');

	like.addEventListener('click', function {
		var httpRequest = new XMLHttpRequest();

		httpRequest.onreadystatechange = function() {
			if (httpRequest.readyState === 4 && httpRequest.status !== 200) {
				console.log('error return requete serveur');
				document.write(httpRequest.status);
				return false;
			}
		}

		httpRequest.open('POST', 'index.php?url=accueil', true);
		httpRequest.setRequestHeader('Content-Type', 'multipart/form-data');
		httpRequest.send(JSON.stringify({ img:img }));
	});
</script>
