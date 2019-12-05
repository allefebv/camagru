<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="public/bulma.css">
        <link rel="icon" href="public/tabicon.ico">
        <title><?= $title ?></title>
    </head>
    <body>
        <div class="hero is-fullheight has-background-dark has-text-white-ter">
            <div class="hero-head">
                <?= $header ?>
            </div>
            <div class="hero-body has-background-grey">
                <?= $content ?>
            </div>
            <div class="hero-foot">
                Made by allefebv
            </div>
        </div>
    </body>
</html>
