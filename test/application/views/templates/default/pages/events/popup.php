<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//modernizr.com/downloads/modernizr-latest.js"></script>
        <link rel="stylesheet" href="/assets/css/reset.css" />
        <link href="//fonts.googleapis.com/css?family=Alegreya+Sans:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" />
        <link rel="stylesheet" href="/assets/templates/<?=GLOBAL_TEMPLATE ?>/css/stylesheet.css" />
        <link rel="stylesheet" href="/assets/templates/<?=GLOBAL_TEMPLATE ?>/css/popup.css" />
        <title><?=$title ?></title>
    </head>
    <body>
        <h1><?=$title ?></h1>
<?=$content ?>
        <div id="close-window"><a href="javascript:void(0);" onclick="window.close();">Close Window</a></div>
    </body>
</html>