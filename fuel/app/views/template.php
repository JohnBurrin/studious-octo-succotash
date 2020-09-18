<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <?php
        echo Asset::css('app.css', array(), null, true);
    ?>

    <script data-ad-client="ca-pub-8371692745987188" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>window._epn = {campaign: 5338733485};</script>

    <script src="https://epnt.ebay.com/static/epn-smart-tools.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-177804611-1"></script>

    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-177804611-1');
    </script>
</head>
<body>
    <!-- Team -->
<section id="team" class="pb-5">
    <div class="container">
        <h1 class="section-title h1"><?php echo $title; ?></h1>
        <p class="text-right"><a href="<?=$link['url']?>"><?=$link['title']?></a></p>
        <?php echo Pagination::instance('mypagination')->render(); ?>
            <div class="row">
                <?php echo $content; ?>

              </div>
            <?php echo Pagination::instance('mypagination')->render(); ?>
          </div>
        </section>
    </body>
</html>
