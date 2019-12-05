<?php $this->_title = 'Accueil';?>
<div class="container has-text-centered has-background-primary">
	<?php foreach($images as $image): ?>
	<img src="<?= $image->pathToImage() ?>"/>
	<?php endforeach; ?>
</div>
