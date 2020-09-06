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
    <body class="has-navbar-fixed-top is-full-height">
        <?= $header ?>
        <div id="notificationList"></div>
        <section id="content" class="section has-text-centered">
            <?= $content ?>
        </section>
        <footer class="level has-background-dark has-text-primary page-footer">
            <div class="container has-text-centered">
                    made by allefebv
            </div>
        </footer>
    </body>
</html>
