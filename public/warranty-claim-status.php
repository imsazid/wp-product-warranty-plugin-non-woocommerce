<?php

global $wpdb, $table_prefix;

$wp_wclaim = $table_prefix.'wclaim';

$userid = get_current_user_id();

$q = "SELECT * FROM `$wp_wclaim` WHERE `user_id` LIKE $userid;";
$c = "SELECT COUNT(id) FROM `$wp_wclaim` WHERE `user_id` = $userid;";

//$q = "SELECT * FROM `$wp_warranty`;";
$results = $wpdb->get_results($q);
$count = $wpdb->get_var($c);
$cf = $count ?: 0;

ob_start();
?>
<div class="wrap">
<p>You have <?php echo $cf ?> Warranty Claim</p>
<?php if($cf!=0): ?>
<table class="wtable">
   <thead>
      <th>Amazon Order ID</th>
      <th>Description</th>
      <th>Claim Date</th>
      <th>Status</th>
   </thead>
   <?php
   foreach($results as $result):
   ?>
   <tr>
      <td><?php echo $result->order_id ?></td>
      <td><?php echo $result->description ?></td>
      <td><?php 
         $datetime = $result->timestamp;
         echo substr($datetime, 0, 10) ?></td>
      <td><?php echo $result->status ?></td>
   </tr>
   <?php
   endforeach
   ?>
</table>
<?php endif ?>

</div>

<?php
echo ob_get_clean();