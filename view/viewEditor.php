<?php $this->_title = 'Editeur';?>
<div class="columns is-desktop is-centered">
	<div class="column is-8 has-background-dark" id="container">
		<div class="card">
			<video autoplay="true" id="webcam"></video>
			<div class="card-content is-overlay">
				<img src="" id="overlay" width=200>
			</div>
		</div>
		<div class="level has-background-black" id="layers">
			<div class="container has-text-centered">
			<?php foreach ($layers as $layer): ?>
				<img src="..<?= $layer->pathToLayer(); ?>" id="<?= $layer->id(); ?>" onclick="focusFilter(this)" width=50px height=50px>
			<?php endforeach; ?>
			</div>
		</div>
		<button type="button" id="save" class="button">Sauvegarder</button>
	</div>
	<div class="column is-3 has-background-black overflow:auto">
		<div class="container has-text-centered" id="previews">
		</div>
	</div>
</div>
<script>
	var video = document.getElementById('webcam');
	var layer = document.getElementById('layer');
	var overlay = document.getElementById('overlay');
	var activeLayerId;
	var img;

	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia({ video: true })
			.then(function (stream) {
				video.srcObject = stream;
			})
			.catch(function (error) {
				console.log("Something went wrong!");
			});
	}

	function focusFilter(element) {
		console.log(video.getAttribute('width'));
		overlay.setAttribute('src', element.getAttribute('src'));
		activeLayerId = element.getAttribute('id');
	}

	function createCanvas(img) {
		var canv = document.createElement('canvas');
		var context = canv.getContext('2d');

		document.getElementById("previews").appendChild(canv);
		context.drawImage(video, 0, 0, 200, 200);
		img = canv.toDataURL("image/png");
		context.drawImage(overlay, 0, 0, 100, 100);
		return img;
	}

	document.getElementById("save").addEventListener("click", function() {
		var httpRequest = new XMLHttpRequest();
		img = createCanvas(img);

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
