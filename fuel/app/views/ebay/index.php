<?php echo Pagination::instance('mypagination')->render(); ?>
<table class="table">
 <thead>
  <tr>
   <th>Item Id</th>
   <th>Payment Method</th>
   <th>Postcode</th>
   <th>Country</th>
   <th>listing info</th>

   <th>Thumbnail</th>
   <th>Selling status</th>
   <th>condition</th>
   <th>Link to ebay</th>
  </tr>
 </thead>
 <tbody>
  <?php foreach ($this->data['item_data'] as $row_data) { ?>
   <tr>
    <td><?php echo $row_data['itemId']; ?></td>
    <td><?php echo $row_data['paymentMethod']; ?></td>
    <td><?php echo $row_data['postalCode']; ?></td>
    <td><?php echo $row_data['country']; ?></td>
    <td><?php echo $row_data['listingInfo']; ?></td>
    <td>
     <?php
     if ($row_data['galleryURL']){ ?>
     <img width="" src="<?php echo $row_data['galleryURL'];?>" />
     <?php
     }else{
      echo "&nbsp;";
     }
     ?></td>
    <td><?php echo $row_data['sellingStatus']; ?></td>
    <td><?php echo $row_data['condition']; ?></td>
    <td><a href="<?php echo $row_data['viewItemURL'];?>">View on eBay</a></td>
   </tr>
  <?php } ?>
 </tbody>
</table>
<?php echo Pagination::instance('mypagination')->render(); ?>
