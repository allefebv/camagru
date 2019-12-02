<?php $this->_title = 'Editeur';?>
<div class="columns">
	<div class="column is-two-thirds" id="container">
		<video autoplay="true" id="videoElement">
		</video>
		<button class="button" id="snap">Snap Photo</button>
	</div>
	<div class="column is-one-third has-background-primary">
		<canvas id="canvas"></canvas>
	</div>
</div>
<script>
	var video = document.getElementById('videoElement');
	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	var img    = canvas.toDataURL("image/png");

	if (navigator.mediaDevices.getUserMedia) {
	navigator.mediaDevices.getUserMedia({ video: true })
		.then(function (stream) {
		video.srcObject = stream;
		})
		.catch(function (err0r) {
		console.log("Something went wrong!");
		});
	}

	 document.getElementById("snap").addEventListener("click", function() {
	 context.drawImage(video, 0, 0, 200, 200);
	 });
</script>
