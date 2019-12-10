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
			<?php foreach ($layers as $layer): ?>
				<img src="..<?= $layer->pathToLayer(); ?>" id="<?= $layer->id(); ?>" onclick="focusFilter(this)" width=50px height=50px>
			<?php endforeach; ?>
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
<script>
	var background = document.getElementById('webcam');
	var layer = document.getElementById('layer');
	var overlay = document.getElementById('overlay');
	var toSend = document.getElementById('to_send');
	var saveButton = document.getElementById('save');
	var toSendContext = toSend.getContext('2d');
	var activeLayerId;
	var img;

	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia({ video: true })
			.then(function (stream) {
				background.srcObject = stream;
			})
			.catch(function (error) {
				console.log("Something went wrong!");
			});
	}

	function focusFilter(element) {
		activeLayerId = element.getAttribute('id');
		overlay.setAttribute('src', element.getAttribute('src'));
		var saveToolTip = document.getElementById('savetooltip');
		saveToolTip.parentNode.removeChild(saveToolTip);
		save.disabled = false;
	}

	function createCanvas() {
		var canv = document.createElement('canvas');
		canv.width = 160;
		canv.height = 120;
		var context = canv.getContext('2d');
		document.getElementById("previews").appendChild(canv);
		context.drawImage(background, 0, 0, 160, 120);
		context.drawImage(overlay, 40, 5, 80, 120);
	}

	document.getElementById('selectcam').addEventListener("click", function() {
		background.style.display = 'none';
		background = document.getElementById('webcam');
		background.style.display = '';
	});

	function fileImport(element) {
		var reader = new FileReader();
		background.style.display = 'none';
		background = document.getElementById('uploaded-img');
		reader.onload = function (e) {
			background.setAttribute('src', e.target.result);
		};
		reader.readAsDataURL(element.files[0]);
		background.style.display = '';
	}

	save.addEventListener("click", function() {
		var httpRequest = new XMLHttpRequest();
		createCanvas();
		toSendContext.clearRect(0, 0, toSend.width, toSend.height);
		toSendContext.drawImage(background, 0, 0, 320, 240);
		img = toSend.toDataURL("image/png");

		if (!httpRequest) {
			alert('Impossible de creer une instance XMLHTTP');
			return false;
		}

		httpRequest.onreadystatechange = function() {
			if (httpRequest.readyState === 4 && httpRequest.status !== 200) {
				console.log('error return requete serveur');
				document.write(httpRequest.status);
				return false;
			}
		}

		httpRequest.open('POST', 'index.php?url=editor', true);
		httpRequest.setRequestHeader('Content-Type', 'multipart/form-data');
		httpRequest.send(JSON.stringify({ img:img, layer:activeLayerId }));
	});
</script>
