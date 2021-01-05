import * as utils from './utils.js'
import { fetchApi, POST_METHOD } from "./utils.js";

var ownImages = false;

document.addEventListener('DOMContentLoaded', () => {
    utils.getConnexionStatus().then(() => {
        if (sessionStorage.getItem('logged') === 'true') {
            addFilterOwnImages();
        }
    });
    if (window.location.href.indexOf("validation") > -1) {
        utils.notifyUser('success', 'Your account has been activated');
    }
    if (window.location.href.indexOf("l=s") > -1) {
        utils.notifyUser('success', 'Successful login');
    }
    history.pushState({}, '', "index.php");
    getImages();
});

function addFilterOwnImages() {
    utils.createElement('div', null, ['navbar-item'], 'item-my-images', 'nav-start');
    utils.createElement('div', null, ['navbar-item'], 'item-all-images', 'nav-start');
    let ownImagesButton = utils.createElement('button', 'my images', ['button'], null, 'item-my-images');
    let allImagesButton = utils.createElement('button', 'all images', ['button', 'is-success'], null, 'item-all-images');

    ownImagesButton.addEventListener('click', () => {
        allImagesButton.classList.remove('is-success');
        ownImagesButton.classList.add('is-success');
        document.getElementById('gallery').textContent = '';
        ownImages = true;
        getImages(ownImages);
    });

    allImagesButton.addEventListener('click', () => {
        ownImagesButton.classList.remove('is-success');
        allImagesButton.classList.add('is-success');
        document.getElementById('gallery').textContent = '';
        ownImages = false;
        getImages(ownImages);
    })
}

function loadMoreImages() {
    if (sessionStorage.getItem('ajax-in-progress')) {
        return;
    }

    let documentHeight = document.body.clientHeight
    let ScrolledAndVisibleHeight = window.pageYOffset + window.innerHeight
    if ((documentHeight - 300) < ScrolledAndVisibleHeight && sessionStorage.getItem('no-more') !== undefined) {
        getImages(ownImages);
        sessionStorage.setItem('ajax-in-progress', 1)
    }
}

window.addEventListener("scroll", loadMoreImages);
window.addEventListener("resize", loadMoreImages);

const getImages = (onlyOwn) => {
    let last = document.getElementById('gallery').lastChild
    let lastId = last ? last.lastChild.id : null
    if (onlyOwn) {
        utils.ajaxify(
            JSON.stringify({
                getOwnImages:1,
                nbImages:3,
                lastId:lastId
            }),
            getImagesResponse,
            'index.php?url=accueil'
        )
    } else {
        utils.ajaxify(
            JSON.stringify({
                getAllImages:1,
                nbImages:3,
                lastId:lastId
            }),
            getImagesResponse,
            'index.php?url=accueil'
        )
    }
}

const getImagesResponse = (images) => {
    const gallery = document.getElementById('gallery')
    for (var i = 0; i < images.length ; i++) {

        var column = document.createElement('div')
        column.classList.add('column', 'is-one-third')

        var card = document.createElement('div')
        card.classList.add('card', 'gallery-image')
        card.setAttribute('data-bulma-modal-open', 'image')
        card.setAttribute('data-author-id', images[i]._userId);
        card.id = images[i]._id
        card.addEventListener("click", function() {
            changeModalDetails(this)
        })

        if (images[i]._userId === parseInt(sessionStorage.getItem('userId'))) {
            var deleteButton = utils.createElement('button', 'X', ['button', 'delete-image-button']);
            card.appendChild(deleteButton);
    
            deleteButton.addEventListener('click', (e) => {
                utils.fetchApi('index.php', {
                    method: POST_METHOD,
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: {deleteImage: e.currentTarget.parentNode.id},
                }).then((response) => {
                    document.getElementById('gallery').textContent = '';
                    getImages(ownImages);
                });
                e.stopPropagation();
            });
        }

        var cardImage = document.createElement('div')
        cardImage.classList.add('card-image')

        var figure = document.createElement('figure')
        figure.classList.add('image', 'is-16by9')

        var image = document.createElement('img')
        image.src = images[i]._pathToImage

        gallery.appendChild(column)
        column.appendChild(card)
        card.appendChild(cardImage)
        cardImage.appendChild(figure)
        figure.appendChild(image)
    }
    utils.initOpenModals()
    if (images.empty === 1) {
        sessionStorage.setItem('no-more', 1)
    } else if (document.body.clientHeight < window.innerHeight) {
        getImages(ownImages);
    }
    sessionStorage.removeItem('ajax-in-progress')
}

const likeImage = (event) => {
    utils.ajaxify(
        JSON.stringify({ like:1, imageId:event.currentTarget.imageId }),
        likeResponse,
        'index.php?url=accueil'
    )
}

const likeResponse = (responseData) => {
    if (responseData['action'] === 'delete') {
        document.getElementById('like_request').classList.add('is-light');
        document.getElementById('like_request').innerHTML = 'Like'
    } else {
        document.getElementById('like_request').classList.remove('is-light');
        document.getElementById('like_request').innerHTML = 'Unlike'
    }
    let likesNb = document.getElementById('likes-nb');
    likesNb.innerHTML = responseData['likes'];
}   

const postComment = () => {
    let text = document.getElementById('comment_text').value
    if (text) {
        utils.ajaxify(
            JSON.stringify({
                comment:text,
                imageId:sessionStorage.getItem('modal-image-id') }),
            successPostComment,
            'index.php?url=accueil'
        )
    }
}

const successPostComment = (response) => {
    addComment(response.author, response.commentText);
    document.getElementById('comment_text').value = ''
}

const changeModalDetails = (element) => {
    utils.ajaxify(
        JSON.stringify({ getImageDetails:1, imageId:element.id }),
        successGetDetails,
        'index.php?url=accueil'
    )
}

const successGetDetails = (details) => {

    modalBase(details)
    modalHeader(details.imageAuthor)
    modalImage(details.imageDetails)

    utils.createElement('div', null, ['modal-card-body'], 'modal-image-body', 'modal-image-content');

    if (sessionStorage.getItem('logged') === "true") {
        addCommentLikeArea(details.imageDetails)
    }   

    if (details.imageComments) {
        for (let comment of details.imageComments) {
            addComment(comment.author, comment.comment._commentText)
        }
    }

    utils.initCloseModals()
}

const modalBase = (details) => {
    let modalBackground = document.createElement('div');
    modalBackground.classList.add('modal-background');
    modalBackground.setAttribute('data-bulma-modal', 'close');
    modalBackground.setAttribute('data-author-id', details.imageDetails._userId);
    modalBackground.setAttribute('data-author-name', details.imageAuthor);
    utils.initCloseModals()

    let modalContent = document.createElement('div');
    modalContent.classList.add('modal-content');
    modalContent.id = 'modal-image-content';

    document.getElementById('modal-image').appendChild(modalBackground);
    document.getElementById('modal-image').appendChild(modalContent);
}

const modalHeader = (authorName) => {
    let modalHeader = document.createElement('header')
    modalHeader.classList.add('modal-card-head')
    modalHeader.id = 'modal-image-header'

    let level = document.createElement('div')
    level.classList.add('level')

    let leftPart = document.createElement('div')
    leftPart.classList.add('level-left')

    let authorNameLevelItem = document.createElement('div')
    authorNameLevelItem.classList.add('level-item')

    let rightPart = document.createElement('div')
    rightPart.classList.add('level-right')
    
    let author = document.createElement('strong')
    let authorText = document.createTextNode("Image By " + authorName)
        
    document.getElementById('modal-image-content').appendChild(modalHeader)
    modalHeader.appendChild(level)
    level.appendChild(leftPart)
    level.appendChild(rightPart)
    leftPart.appendChild(authorNameLevelItem)
    authorNameLevelItem.appendChild(author)
    author.appendChild(authorText)
}

const modalImage = (imageDetails) => {
    let imageContainer = document.createElement('p')
    imageContainer.classList.add('image', 'is-16by9')
    imageContainer.id = 'modal-image-image'

    let image = document.createElement('img')
    image.src = imageDetails._pathToImage

    document.getElementById('modal-image-content').appendChild(imageContainer)
    imageContainer.appendChild(image)
    sessionStorage.setItem('modal-image-id', imageDetails._id)
}

const addCommentLikeArea = (imageDetails) => {
    let level = document.createElement('div')
    level.classList.add('level')

    let leftPart = document.createElement('div')
    leftPart.classList.add('level-left')

    let commentBoxDiv = document.createElement('div')
    commentBoxDiv.classList.add('level-item')

    let commentTextArea = document.createElement('textarea')
    commentTextArea.classList.add('textarea')
    commentTextArea.id = "comment_text"
    commentTextArea.rows = "1"
    commentTextArea.placeholder = "Comment"

    let commentButtonDiv = document.createElement('div')
    commentButtonDiv.classList.add('level-item')

    let commentButton = document.createElement('button')
    commentButton.classList.add('button')
    commentButton.id = 'comment_request'
    commentButton.addEventListener('click', postComment)

    let commentButtonText = document.createTextNode('Post')
    commentButton.appendChild(commentButtonText)

    let rightPart = document.createElement('div')
    rightPart.classList.add('level-right')

    let likeButtonDiv = document.createElement('div')
    likeButtonDiv.classList.add('level-item')

    let likeButton = document.createElement('button')
    likeButton.id = 'like_request'
    likeButton.imageId = imageDetails._id
    likeButton.addEventListener('click', likeImage)
    utils.fetchApi('index.php?url=accueil',
        {
            method: POST_METHOD,
            headers: {
                "Content-Type": "application/json",
            },
            body: {hasUserLikedImage: 1, imageId: imageDetails._id}
        }).then((response) => {
            if (response.like_status === true) {
                likeButton.classList.add('button', 'is-link')
                likeButton.innerHTML = 'Unlike'
            } else {
                likeButton.classList.add('button', 'is-light', 'is-link')
                likeButton.innerHTML = 'Like'
            }
        });

    let likeNbDiv = utils.createElement('div', imageDetails._likes, ['level-item'], 'likes-nb')

    document.getElementById('modal-image-body').appendChild(level)
    level.appendChild(leftPart)
    level.appendChild(rightPart)
    leftPart.appendChild(commentBoxDiv)
    commentBoxDiv.appendChild(commentTextArea)
    leftPart.appendChild(commentButtonDiv)
    commentButtonDiv.appendChild(commentButton)
    rightPart.appendChild(likeButtonDiv)
    rightPart.appendChild(likeNbDiv);
    likeButtonDiv.appendChild(likeButton)
}

const addComment = (authorText, commentText) => {
    let article = document.createElement('article')
    article.classList.add('media')

    let mediaContent = document.createElement('div')
    mediaContent.classList.add('media-content')

    let content = document.createElement('div')
    content.classList.add('content')

    let authorElement = document.createElement('strong')
    let authorTextElement = document.createTextNode(authorText)
    let commentElement = document.createElement('p')
    let commentTextElement = document.createTextNode(commentText)

    document.getElementById('modal-image-body').appendChild(article)
    article.appendChild(mediaContent)
    mediaContent.appendChild(content)
    content.appendChild(authorElement)
    content.appendChild(commentElement)
    authorElement.appendChild(authorTextElement)
    commentElement.appendChild(commentTextElement)
}