function ajaxify(jsonString) {
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === 4 && httpRequest.status !== 200) {
            console.log('error return requete serveur');
            document.write(httpRequest.status);
            return false;
        }
        else if (httpRequest.readyState === 4 && httpRequest.status === 200) {
            var httpResponse = httpRequest.response;
            if (httpResponse) {
                var obj = JSON.parse(httpRequest.response);
            }
            if (obj && 'like' in obj) {
                likeResponse(jsonString, obj);
            }
        }
    }
    httpRequest.open('POST', 'index.php?url=accueil', true);
    httpRequest.setRequestHeader('Content-Type', 'multipart/form-data');
    httpRequest.send(jsonString);
}

function likeImage(likeButton) {
    buttonId = likeButton.getAttribute('id');
    imgId = buttonId.match(/\d+/)[0];
    ajaxify(JSON.stringify({ like:1, imageId:imgId }));
}

function likeResponse(sentData, responseData) {
    json = JSON.parse(sentData);
    likesNb = document.getElementById('likes' + json['imageId']);
    likesNb.innerHTML = responseData['likes'];
}

function addCommentNode(commentText, imgId) {

}

function postComment(commentButton) {
    buttonId = commentButton.getAttribute('id');
    imgId = buttonId.match(/\d+/)[0];
    commentText = document.getElementById('text' + imgId).value;
    ajaxify(JSON.stringify({ comment:1, imageId:imgId, commentText:commentText }));
}