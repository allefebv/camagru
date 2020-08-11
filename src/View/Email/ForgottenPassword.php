<?php
    $subject = "forgotten password";
?>

<html>
    <body>
        <h1>Hello <?= $user->username() ?></h1>
        <p>Please find your new password below</p>
        <p><?= $password ?></p>
        <p>Keep it secret. You can change it in your account section at anytime</p>
    </body>
</html>