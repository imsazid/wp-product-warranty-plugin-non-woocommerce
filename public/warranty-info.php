<?php
if(isset($_POST['wclaim'])){
    global $wpdb,$table_prefix;
    $wp_wclaim = $table_prefix.'wclaim';
    $wp_warranty = $table_prefix.'warranty';
    $warrentyida = $wpdb->escape($_POST['warranty_id']);

    $q = "SELECT `order_id` FROM `$wp_warranty` WHERE `id`=$warrentyida";
    $orderid = $wpdb->get_var($q);

    $description = $wpdb->escape($_POST['description']);
    $userid = get_current_user_id();

    $data = array(
        'user_id' => $userid,
        'warranty_id' => $warrentyida,
        'description' => $description,
        'order_id' => $orderid,
    
    );
    
    $wpdb->insert($wp_wclaim, $data);
}


?>

<?php

global $wpdb, $table_prefix;

$wp_warranty = $table_prefix.'warranty';

$userid = get_current_user_id();

$q = "SELECT * FROM `$wp_warranty` WHERE `user_id` LIKE $userid;";
$c = "SELECT COUNT(id) FROM `$wp_warranty` WHERE `user_id` = $userid;";

//$q = "SELECT * FROM `$wp_warranty`;";
$results = $wpdb->get_results($q);

$count = $wpdb->get_var($c);
$cf = $count ?: 0;

ob_start();
?>
<div class="wrap">
<p>You have Added <?php echo $cf ?> Products for Warranty</p>
<?php if($cf!=0): ?>
<table class="wtable">
   <thead>
      <th>Amazon Order Id</th>
      <th>Order Date</th>
      <th>Warranty Expiary Date</th>
      <th>Action</th>
   </thead>
   <?php
   foreach($results as $result):
   ?>
   <tr>
      <td><?php echo $result->order_id ?></td>
      <td><?php echo $result->purchase_date ?></td>
      <td>
        <?php
        $orderdate = $result->purchase_date;
        $warrantytime = 12;
        $warrantydate = strtotime("+".$warrantytime." months", strtotime($orderdate));
        $currentdate = strtotime(date("Y-m-d"));
        $remainday = ($warrantydate - $currentdate)/(24*60*60);       
        $warrantyfinal = date("Y-m-d", $warrantydate);
        echo $warrantyfinal.' (In '.$remainday.' days)';
        ?>
    </td> 
    <td>
        <form action="<?php echo get_the_permalink().'/claim'?>" method="get" class="tform">
            <input type="hidden" name="warranty_id" value="<?php echo $result->id ?>">
            <input type="submit" value="Claim Warranty">
        </form>
    </td>
   </tr>
   <?php
   endforeach
   ?>
</table>
<?php endif ?>

</div>

<?php
echo ob_get_clean();