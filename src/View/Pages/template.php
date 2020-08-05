<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="public/styles/bulma.css">
        <link rel="stylesheet" href="public/styles/camagru.css">
        <link rel="icon" href="public/tabicon.ico">
        <title><?= $title ?></title>
    </head>
    <body class="hero is-fullheight has-background-black">
        <?= $header ?>
        <div id="notificationList"></div>
        <section id="content" class="section has-text-centered has-background-dark has-text-white">
            <?= $content ?>
        </section>
        <footer id="footer" class="footer has-background-black">
            <div class="content has-text-centered is-size-2 has-text-primary is-uppercase">
                Made by allefebv
            </div>
        </footer>
    </body>
</html>
