import { fetchApi, POST_METHOD } from "./utils.js";
import * as utils from './utils.js'

var background = document.getElementById('webcam');
var importNode = document.getElementById('import');
var layersNode = document.getElementById('layers');
var overlay = document.getElementById('overlay');
var toSend = document.getElementById('to_send');
var saveButton = document.getElementById('save');
var toSendContext = toSend.getContext('2d');
var userHasWebcam;
var activeLayerId;
var img;

document.addEventListener('DOMContentLoaded', () => {
    importNode.addEventListener('change', fileImport);
});

navigator.getMedia = ( navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

navigator.getMedia(
    {video: { width: 480, height: 270 }},
    (stream) => {
        background.srcObject = stream;
        userHasWebcam = true;
        getLayers();
        document.getElementById('savetooltip').innerHTML = 'Please select a filter';
    },
    () => { 
        userHasWebcam = false;
        document.getElementById('selectcam').style.display = 'none';
        document.getElementById('savetooltip').innerHTML = 'Please import an image';
    }
);

function getLayers() {
    fetchApi(
        'index.php?url=editor',
    {
        method: POST_METHOD,
        headers: {
            "Content-Type": "application/json",
        },
        body: {getLayers: true},
    })
    .then((layers) => {
        for(let layer of layers) {
            let img = document.createElement('img');
            img.setAttribute('src', layer._pathToLayer);
            img.setAttribute('id', layer._id);
            img.setAttribute('width', '50px');
            img.setAttribute('height', '50px');
            img.addEventListener("click", () => focusFilter(img));
            layersNode.appendChild(img);
        }
    })
    .catch((error) => console.log(error));
}

function focusFilter(element) {
    activeLayerId = element.getAttribute('id');
    overlay.setAttribute('src', element.getAttribute('src'));
    var saveToolTip = document.getElementById('savetooltip');
    if (saveToolTip) {
        saveToolTip.parentNode.removeChild(saveToolTip);
    }
    saveButton.disabled = false;
}

document.getElementById('selectcam').addEventListener("click", function() {
    background.style.display = 'none';
    background = document.getElementById('webcam');
    background.style.display = '';
});

//CONTROL IMAGE ASPECT RATIO SIZE
function fileImport(event) {
    let file = event.currentTarget.files[0];
    let img = new Image();
    let _URL = window.URL || window.webkitURL;
    let objectUrl = _URL.createObjectURL(file);
    img.onload = function () {
        if (this.width / this.height > 16 / 8.5 || this.width / this.height < 16 / 9.5) {
            utils.notifyUser('error', 'image must be 16:9 ratio');
        } else {
            background.style.display = 'none';
            background = document.getElementById('uploaded-img');
            background.width = 480;
            background.height = 270;
            background.setAttribute('src', objectUrl);
            background.style.display = '';
            if (layersNode.getElementsByTagName('img').length === 0) {
                getLayers();
                document.getElementById('savetooltip').innerHTML = 'Please select a filter';
            }
        }
        _URL.revokeObjectURL(objectUrl);
    };
    img.src = objectUrl;
}

function saveImage(details, container) {
    fetchApi(
        'index.php?url=editor',
        {
            method: POST_METHOD,
            headers: {
                "Content-Type": "application/json",
            },
            body: details,
        }).then(() => {
            utils.notifyUser("success", "Your image has been saved");
            deleteImage(container);
        }).catch((error) => console.log(error));
}

function deleteImage(container) {
    container.remove();
}

function addPreview(json) {

    let container = document.createElement('div');
    container.classList.add('container', 'preview-container');
    document.getElementById('previews').appendChild(container);

    let img = new Image(480, 270)
    img.src = 'data:img/jpg;base64,' + json.img;
    container.appendChild(img);

    let buttonsContainer = utils.createElement('div', null, ['buttons-container']);
    container.appendChild(buttonsContainer);

    let saveButton = document.createElement('button');
    saveButton.addEventListener('click', () => saveImage({save:json.img}, container));
    saveButton.classList.add('button');
    saveButton.innerHTML = 'Save';
    buttonsContainer.appendChild(saveButton);

    let deleteButton = document.createElement('button');
    deleteButton.addEventListener('click', () => deleteImage(container));
    deleteButton.classList.add('button', 'danger');
    deleteButton.innerHTML = 'Delete';
    buttonsContainer.appendChild(deleteButton);
}

const createImageMontage = (details) => {
    return fetchApi(
        'index.php?url=editor',
        {
            method: POST_METHOD,
            headers: {
                "Content-Type": "application/json",
            },
            body: details,
        });
    };

saveButton.addEventListener("click", function() {
    toSendContext.clearRect(0, 0, toSend.width, toSend.height);
    toSendContext.drawImage(background, 0, 0, 480, 270);
    img = toSend.toDataURL("image/jpg");
    createImageMontage({img:img, layer:activeLayerId, width: overlay.width, height: overlay.height})
        .then((json) => {
            addPreview(json);
        })
        .catch();
});