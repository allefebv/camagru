<?php $this->_title = 'Editeur';?>
<div class="columns">
	<div class="column is-two-thirds has-background-danger" id="container">
		<video autoplay="true" id="videoElement"></video>
		<button type="button" id="save" class="button">Sauvegarder</button>
	</div>
	<div id="previews" class="column is-one-third is-pulled-right has-background-primary overflow-y:scroll">
		<canvas id="canvas"></canvas>
	</div>
</div>
<script>
	var video = document.getElementById('videoElement');
	var canvas = document.getElementById('canvas');
	var httpRequest;
	var id = 1;
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

	function createCanvas(img) {
		var canv = document.createElement('canvas');
		var context = canv.getContext('2d');

		canv.setAttribute('id', 'canvas' + id++);
		document.getElementById("previews").appendChild(canv);
		context.drawImage(video, 0, 0, 200, 200);

		img = canv.toDataURL("image/png");
		return img;
	}

	document.getElementById("save").addEventListener("click", function() {
		httpRequest = new XMLHttpRequest();
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
		httpRequest.send(JSON.stringify({img:img}));
	});
</script>
