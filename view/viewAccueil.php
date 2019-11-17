<?php $this->_title = 'Accueil';
foreach($comments as $comment): ?>
<h2><?= $comment->author() ?></h2>
<p><?= $comment->text() ?><p>
<?php endforeach; ?>
