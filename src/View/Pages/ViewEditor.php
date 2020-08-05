<?php $this->_title = 'Editeur';?>
<div class="columns is-desktop is-centered">
	<div class="column is-narrow has-background-dark" id="container">
		<label for="import" class="button import-file">Importer Une Image</label>
		<input type="file" id="import" class="input-file" accept="image/*" onchange="fileImport(this)">
		<button type="button" id="selectcam" class="button">Retour sur la cam</button>
		<div id="background-container" class="card has-background-dark ">
			<video autoplay="true" class="background-content" id="webcam" poster="../public/peepoodo.png"></video>
			<img src="" class="background-content" id="uploaded-img" style="display:none;">
			<div class="card-content is-overlay">
				<img src="" id="overlay">
			</div>
			<canvas style="display:none;" id="to_send" width="320" height="240">
		</div>
		<div class="level has-background-black" id="layers">
			<div class="container has-text-centered">
			<?php if (isset($layers)): ?>
				<?php foreach ($layers as $layer): ?>
					<img src="..<?= $layer->pathToLayer(); ?>" id="<?= $layer->id(); ?>" onclick="focusFilter(this)" width=50px height=50px>
				<?php endforeach; ?>
			<?php endif; ?>
			</div>
		</div>
		<span class="tooltip">
			<button type="button" id="save" class="button" disabled>Sauvegarder</button>
			<div id="savetooltip" class="tooltiptext">Vous devez choisir un filtre</div>
		</span>
	</div>
	<div class="column is-4"></div>
	<div class="column is-4 has-background-black">
		<div class="container" id="previews">
		</div>
	</div>
</div>

<script type="text/javascript" src="/public/scripts/editor.js"></script>