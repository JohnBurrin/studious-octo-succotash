<?php
$count = 1;
foreach ($this->data['item_data'] as $row_data) {
    $listingInfo = json_decode($row_data['listingInfo']);
    $paymentMethod = json_decode($row_data['paymentMethod']);
    $shippingInfo = json_decode($row_data['shippingInfo'], true);
    $condition = json_decode($row_data['condition']);
    $sellingStatus = json_decode($row_data['sellingStatus'], true);
    $date = $listingInfo->endTime[0];
    $endDateTime = new DateTime($date);
    $now = new DateTime();
    $interval = $now->diff($endDateTime);

    (isset($listingInfo->watchCount) && $listingInfo->watchCount[0] > 1) ? $watcherplural ="s" : $watcherplural = "";
    (isset($sellingStatus['bidCount']) && $sellingStatus['bidCount'][0] > 1) ? $bidderplural ="s" : $bidderplural = "";
    (isset($row_data['postalCode']) && strpos($row_data['location'], "United Kingdom")) ? $postalCode = ", " . $row_data['postalCode'] : $postalCode = "";
    $postalCode = substr_replace($postalCode, " ", -3, 0);
    if (($count++ % 6) == 0) {
        ?>

        <?php
    } else {
        ?>
    <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
            <div class="mainflip">
                <div class="frontside">
                    <div class="card">
                        <div class="card-body text-center">
                            <p>
                                <a href="<?php echo $row_data['viewItemURL'];?>">
                                    <img class="img-fluid toggle-map" src="<?php echo $row_data['galleryURL'];?>" aria-label="<?php echo $row_data['title']; ?>" alt="<?php echo $row_data['title']; ?>" >
                                </a>
                            </p>
                            <h2 class="card-title"><?php echo $row_data['title']; ?></h2>
                            <p class="card-text">
                                <a href="<?php echo $row_data['viewItemURL'];?>" class="btn btn-primary btn-sm">View On eBay</a>
                            </p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    Price: <?= $sellingStatus['currentPrice'][0]['__value__'] ?> <?= $sellingStatus['currentPrice'][0]['@currencyId'] ?> /
                                    <?php if (isset($shippingInfo['shippingServiceCost'])) { ?>
                                    Shipping: <?= $shippingInfo['shippingServiceCost'][0]['__value__'] ?> <?= $shippingInfo['shippingServiceCost'][0]['@currencyId']?>
                                    <?php } ?>
                                </li>
                                <li class="list-group-item">
                                    <?php echo $row_data['location']; ?> <a href="#" data-location="<?=$postalCode?>" data-id="<?=$row_data['itemId']?>" data-toggle="modal" data-target="#locationModal"><?= $postalCode ?></a>
                                </li>
                                <li class="list-group-item">
                                    <?= (isset($listingInfo->watchCount)) ? $listingInfo->watchCount[0] . " watcher".$watcherplural : "0 watchers" ?>
                                </li>
                                <li class="list-group-item"><?= (isset($sellingStatus['bidCount'])) ? $sellingStatus['bidCount'][0] . " bid".$bidderplural : "0 bids" ?></li>
                                <?php if (isset($listingInfo->listingType)) { ?>
                                    <li class="list-group-item">Listing Type: <?=$listingInfo->listingType[0] ?></li>
                                <?php }?>
                                <li class="list-group-item">Condition:<?= (isset($condition->conditionDisplayName[0]) ? $condition->conditionDisplayName[0] : "") ?></li>
                                <li class="list-group-item">
                                    <?php if (isset($row_data['storeName'])) {
                                          echo "<a href=\"" .  $row_data['storeURL']. "\">" . $row_data['storeName'] ."</a>";
                                    } else {
                                        echo "Seller: " .$row_data['sellerUserName'];
                                    }?>
                                (<?=$row_data['feedbackScore']?>)
                                </li>
                                <li class="list-group-item"><?= ($interval->format("%R") =="-") ? "<b class=\"text-danger\">Ended</b>" : "Time left " . $interval->format('%a days %Hh %Im %Ss')?></li>
                            </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
        <?php
    }
}
?>
