import * as utils from './utils.js'


const like_request_buttons = document.getElementsByClassName('select-choice')
Array.prototype.forEach.call(like_request_buttons, function(item) {
    
}

function likeImage(likeButton) {
    buttonId = likeButton.getAttribute('id');
    imgId = buttonId.match(/\d+/)[0];
    utils.ajaxify(
        JSON.stringify({ like:1, imageId:imgId }),
        likeResponse,
        'index.php?url=accueil'
    );
}

const likeResponse = (responseData) => {
    likesNb = document.getElementById('likes' + responseData['imageId']);
    likesNb.innerHTML = responseData['likes'];
}

function postComment(commentButton) {
    buttonId = commentButton.getAttribute('id');
    imgId = buttonId.match(/\d+/)[0];
    commentText = document.getElementById('text' + imgId).value;
    ajaxify(JSON.stringify({ comment:1, imageId:imgId, commentText:commentText }));
}