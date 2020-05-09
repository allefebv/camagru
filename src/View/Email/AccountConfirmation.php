<?php
    $subject = "account confirmation";
?>

<html>
    <body>
        <h1>Bonjour <?= $user->username() ?></h1>
        <p>Veuillez cliquer sur le lien ci-dessous pour activer votre compte</p>
        <a href="http://localhost:8080/index.php?url=validate&user=<?= $user->key() ?>">Valider mon compte</a>
    </body>
</html>