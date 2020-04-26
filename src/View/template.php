<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="public/bulma.css">
        <link rel="icon" href="public/tabicon.ico">
        <title><?= $title ?></title>
        <style>
            .background-content {
                width:320px;
                height:240px;
            }
            #overlay {
                max-width:100%;
                max-height:100%;
            }
            .tooltiptext {
                visibility: hidden;
                color: #fff;
            }

            .tooltip:hover .tooltiptext {
                visibility: visible;
            }

            .tooltip {
                overflow: overlay;
            }

            .input-file {
                display: none;
            }

            .import-file {
                cursor: pointer;
            }
        </style>
    </head>
    <body class="hero is-fullheight has-background-black">
        <?= $header ?>
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
