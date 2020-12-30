<?php $this->_title = 'Editeur';?>
<div class="columns is-desktop is-centered">
	<div class="column is-narrow has-background-dark" id="container">
		<label for="import" class="button import-file">Import an image</label>
		<input type="file" id="import" class="input-file" accept="image/*">
		<button type="button" id="selectcam" class="button">Back to webcam</button>
		<div class="card has-background-dark editor">
			<video autoplay="true" class="background-content" id="webcam" poster="../public/no_camera.jpg" width="480" height="270"></video>
			<img src="" class="background-content img-editor-hidden" id="uploaded-img" style="display:none;">
			<div class="card-content is-overlay">
				<img src="" id="overlay">
			</div>
			<canvas style="display:none;" id="to_send" width="480" height="270">
		</div>
		<div class="level has-background-black">
			<div id="layers" class="container has-text-centered">
				<!-- DYNAMIC CONTENT JS -->
			</div>
		</div>
		<span class="tooltip">
			<button type="button" id="save" class="button" disabled>Shoot</button>
			<div id="savetooltip" class="tooltiptext"><!-- DYNAMIC CONTENT JS --></div>
		</span>
	</div>
	<div class="column is-4"></div>
	<div class="column is-4 has-background-black">
		<div class="container" id="previews">
		</div>
	</div>
</div>

<script type="module" src="/public/scripts/editor.js"></script>