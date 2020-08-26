<?php echo Pagination::instance('mypagination')->render(); ?>
 <div class="card-deck justify-content-center">
  <?php foreach ($this->data['item_data'] as $row_data) {
      $listingInfo = json_decode($row_data['listingInfo']);
      $paymentMethod = json_decode($row_data['paymentMethod']);
      $shippingInfo = json_decode($row_data['shippingInfo'],true);
      $condition = json_decode($row_data['condition']);
      $sellingStatus = json_decode($row_data['sellingStatus'],true);
      $date = $listingInfo->endTime[0];
      $endDateTime = new DateTime($date);
      $now = new DateTime();
      $interval = $now->diff($endDateTime);
     ?>
     <div class="col-auto mb-3">
        <div class="card" style="width: 50rem;">
            <a href="<?php echo $row_data['viewItemURL'];?>">
                <img class="card-img-top" src="<?php echo $row_data['galleryURL'];?>" alt="...">
            </a>
          <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"><?php echo $row_data['title']; ?></p>
            <ul class="list-group list-group-flush">
                 <li class="list-group-item">Price: <?= $sellingStatus['currentPrice'][0]['__value__'] ?> <?= $sellingStatus['currentPrice'][0]['@currencyId']?> <br />
                     Shipping: <?= $shippingInfo['shippingServiceCost'][0]['__value__'] ?> <?= $shippingInfo['shippingServiceCost'][0]['@currencyId']?></li>
                 <?php
                 (isset($listingInfo->watchCount) && $listingInfo->watchCount[0] > 1) ? $plural ="s" : $plural = "";
                  ?>
              <li class="list-group-item"><?= (isset($listingInfo->watchCount)) ? $listingInfo->watchCount[0] . " watcher".$plural : "0 watchers" ?></li>
              <!--li class="list-group-item">Best Offer is<?= ($listingInfo->bestOfferEnabled[0] === "true" ? "" : "n't" )?> available</li>
              <li class="list-group-item">Buy it now is<?= ($listingInfo->buyItNowAvailable[0] === "true" ? "" : "n't" )?> available</li-->
              <li class="list-group-item">Condition:<?= $condition->conditionDisplayName[0] ?></li>
              <li class="list-group-item">Time left <?= $interval->format('%a days %Hh %Im %Ss')?></li>
            </ul>
            <div class="col text-center mt-2">
              <a href="<?php echo $row_data['viewItemURL'];?>" class="btn btn-primary">View On eBay</a>
            </div>
          </div>
        </div>
    </div>
  <?php } ?>
</div>

<?php echo Pagination::instance('mypagination')->render(); ?>
