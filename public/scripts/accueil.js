import * as utils from './utils.js'

document.addEventListener('DOMContentLoaded', () => {
    utils.getConnexionStatus()
    getImages()
});

window.addEventListener("scroll", function() {
    if (sessionStorage.getItem('ajax-in-progress')) {
        return;
    }

    let documentHeight = document.body.clientHeight
    let ScrolledAndVisibleHeight = window.pageYOffset + window.innerHeight
    if ((documentHeight - 300) < ScrolledAndVisibleHeight && sessionStorage.getItem('no-more') !== undefined) {
        getImages()
        sessionStorage.setItem('ajax-in-progress', 1)
    }
})

const likeImage = (event) => {
    utils.ajaxify(
        JSON.stringify({ like:1, imageId:event.currentTarget.imageId }),
        likeResponse,
        'index.php?url=accueil'
    )
}

const likeResponse = (responseData) => {
    let likesNb = document.getElementById('likes-number');
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

const getImages = () => {
    let last = document.getElementById('gallery').lastChild
    let lastId = last ? last.lastChild.id : null
    utils.ajaxify(
        JSON.stringify({
            getImages:1,
            nbImages:3,
            lastId:lastId
        }),
        getImagesResponse,
        'index.php?url=accueil'
    )
}

const getImagesResponse = (images) => {
    const gallery = document.getElementById('gallery')
    for (var i = 0; i < images.length ; i++) {

        var column = document.createElement('div')
        column.classList.add('column', 'is-one-third')

        var card = document.createElement('div')
        card.classList.add('card', 'gallery-image')
        card.setAttribute('data-bulma-modal-open', 'image')
        card.id = images[i]._id
        card.addEventListener("click", function() {
            changeModalDetails(this)
        })

        var cardImage = document.createElement('div')
        cardImage.classList.add('card-image')

        var figure = document.createElement('figure')
        figure.classList.add('image', 'is-4by3')

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
        getImages()
    }
    sessionStorage.removeItem('ajax-in-progress')
}

const changeModalDetails = (element) => {
    utils.ajaxify(
        JSON.stringify({ getImageDetails:1, imageId:element.id }),
        successGetDetails,
        'index.php?url=accueil'
    )
}

const successGetDetails = (details) => {

    modalBase()
    modalHeader(details.imageAuthor, details.imageDetails._likes)
    modalImage(details.imageDetails)
    console.log(details)

    let modalCardBody = document.createElement('div')
    modalCardBody.classList.add('modal-card-body')
    modalCardBody.id = 'modal-image-body'
    document.getElementById('modal-image-content').appendChild(modalCardBody)

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

const modalBase = () => {
    let modalBackground = document.createElement('div')
    modalBackground.classList.add('modal-background')
    modalBackground.setAttribute('data-bulma-modal', 'close')
    utils.initCloseModals()

    let modalContent = document.createElement('div')
    modalContent.classList.add('modal-content')
    modalContent.id = 'modal-image-content'

    document.getElementById('modal-image').appendChild(modalBackground)
    document.getElementById('modal-image').appendChild(modalContent)
}

const modalHeader = (authorName, likesNb) => {
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

    let likesNbLevelItem = document.createElement('div')
    likesNbLevelItem.classList.add('level-item')
    
    let author = document.createElement('strong')
    let authorText = document.createTextNode("Image By " + authorName)
        
    let likes = document.createElement('strong')
    likes.id = 'likes-number'
    let likesText = document.createTextNode(likesNb)
    
    document.getElementById('modal-image-content').appendChild(modalHeader)
    modalHeader.appendChild(level)
    level.appendChild(leftPart)
    level.appendChild(rightPart)
    leftPart.appendChild(authorNameLevelItem)
    rightPart.appendChild(likesNbLevelItem)
    authorNameLevelItem.appendChild(author)
    likesNbLevelItem.appendChild(likes)
    author.appendChild(authorText)
    likes.appendChild(likesText)
}

const modalImage = (imageDetails) => {
    let imageContainer = document.createElement('p')
    imageContainer.classList.add('image', 'is-4by3')
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
    likeButton.classList.add('button', 'is-danger')
    likeButton.id = 'like_request'
    likeButton.imageId = imageDetails._id
    likeButton.addEventListener('click', likeImage)

    let likeButtonText = document.createTextNode('Like')
    likeButton.appendChild(likeButtonText)

    document.getElementById('modal-image-body').appendChild(level)
    level.appendChild(leftPart)
    level.appendChild(rightPart)
    leftPart.appendChild(commentBoxDiv)
    commentBoxDiv.appendChild(commentTextArea)
    leftPart.appendChild(commentButtonDiv)
    commentButtonDiv.appendChild(commentButton)
    rightPart.appendChild(likeButtonDiv)
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