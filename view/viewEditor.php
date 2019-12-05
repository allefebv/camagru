<?php $this->_title = 'Editeur';?>
<div class="columns">
	<div class="column is-two-thirds has-background-danger" id="container">
		<video autoplay="true" id="videoElement"></video>
		<button type="button" id="save" class="button">Sauvegarder</button>
	</div>
	<div class="column is-one-third is-pulled-right has-background-primary overflow-y:scroll">
		<canvas id="canvas"></canvas>
	</div>
</div>
<script>
	var video = document.getElementById('videoElement');
	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	var httpRequest;

	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia({ video: true })
			.then(function (stream) {
				video.srcObject = stream;
			})
			.catch(function (error) {
				console.log("Something went wrong!");
			});
	}

	document.getElementById("save").addEventListener("click", function() {
		context.drawImage(video, 0, 0, 200, 200);
		var img = canvas.toDataURL("image/png");
		httpRequest = new XMLHttpRequest();

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
