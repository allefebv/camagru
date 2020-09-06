var background = document.getElementById('webcam');
var layer = document.getElementById('layer');
var overlay = document.getElementById('overlay');
var toSend = document.getElementById('to_send');
var saveButton = document.getElementById('save');
var toSendContext = toSend.getContext('2d');
var activeLayerId;
var img;

navigator.getMedia = ( navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

navigator.getMedia({video: true}, function() {
        background.srcObject = stream;
    }, function() {
});

function focusFilter(element) {
    activeLayerId = element.getAttribute('id');
    overlay.setAttribute('src', element.getAttribute('src'));
    var saveToolTip = document.getElementById('savetooltip');
    if (saveToolTip) {
        saveToolTip.parentNode.removeChild(saveToolTip);
    }
    saveButton.disabled = false;
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

saveButton.addEventListener("click", function() {
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