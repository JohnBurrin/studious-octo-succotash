<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <?php echo Asset::css('bootstrap.css'); ?>
    <style>
        body { margin: 40px; }
    </style>
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
    <div class="container-fluid mt-4">

            <h1><?php echo $title; ?></h1>
            <p class="text-right"><a href="<?=$link['url']?>"><?=$link['title']?></a></p>
            <hr>
            <?php echo $content; ?>
        <footer>
            <p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
        </footer>
    </div>
</body>
</html>
