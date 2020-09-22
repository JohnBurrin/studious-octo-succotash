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

<script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet' />
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

        <!-- Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="locationModalLabel">Approximate Location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id='map' style='width: 100%; height: 300px;'></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
        <script>

        mapboxgl.accessToken = '<?= $mapbox_api_key?>';
          $('#locationModal').on('show.bs.modal', function (event) {
            var request = $(event.relatedTarget)
            $.ajax({
                    url: "https://api.mapbox.com/geocoding/v5/mapbox.places/" + request.data('location') + ".json",
                    type:"get",
                    data: {
                      access_token: mapboxgl.accessToken,
                    }

                  }).done(function(result) {
                    var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
                    center: result.features[0].center, // starting position [lng, lat]
                    zoom: 9 // starting zoom
                    });
                    var marker = new mapboxgl.Marker()
                      .setLngLat(result.features[0].center)
                      .addTo(map);
                  });
          });
          //https://api.mapbox.com/geocoding/v5/mapbox.places/LN12UE.json?access_token=pk.eyJ1Ijoiam9ubnlob25kYSIsImEiOiJjazRqbzR2c3cwYnprM2ttbDc2bnlzZHE2In0.0jsVlBJp9kgijV8NihuJ3w
        </script>
    </body>
</html>
