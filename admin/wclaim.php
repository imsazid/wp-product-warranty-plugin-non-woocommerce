<?php
echo '<h1>Warranty Claim List</h1>';

global $wpdb, $table_prefix;

$wp_wclaim = $table_prefix.'wclaim';
$wp_users = $table_prefix.'users';

$userid = get_current_user_id();

if(isset($_GET['my_search_term'])){
    $q = "SELECT * FROM `$wp_wclaim` WHERE `order_id` LIKE '%".$_GET['my_search_term']."%';";
    $c = "SELECT COUNT(id) FROM `$wp_wclaim` WHERE `order_id` LIKE '%".$_GET['my_search_term']."%';";
}
else{
    $q = "SELECT * FROM `$wp_wclaim`;";
    $c = "SELECT COUNT(id) FROM `$wp_wclaim`;";
}



//$q = "SELECT * FROM `$wp_warranty`;";
$results = $wpdb->get_results($q);
$count = $wpdb->get_var($c);
$cf = $count ?: 0;

ob_start();
?>
<div class="wrap">
    <div class="my-form">
        <form action="<?php echo admin_url('admin.php'); ?>">
            <input type="hidden" name="page" value="claim">
            <input type="text" name="my_search_term" id="my_search_term">
            <input type="submit" name="search" value="search">
        </form>
    </div>
<p>There are <?php echo $cf ?> Warranty Claim</p>
<?php if($cf!=0): ?>
<table class="wp-list-table widefat fixed striped table-view-list posts">
   <thead>
      <th>User ID</th>
      <th>User Name</td>
      <th>User Email</th>
      <th>Amazon Order ID</th>
      <th>Description</th>
      <th>Claim Date</th>
      <th>Status</th>
   </thead>
   <?php
   foreach($results as $result):
   ?>
   <tr>
      <td><?php echo $result->user_id ?></td>
      <td>
        <?php  
            $n = "SELECT `display_name` FROM `$wp_users` WHERE `ID` = $result->user_id;";
            $usersname = $wpdb->get_var($n);
            echo $usersname;  
        ?>
      </td>
      <td>
        <?php  
            $u = "SELECT `user_email` FROM `$wp_users` WHERE `ID` = 		 $result->user_id;";
            $usermail = $wpdb->get_var($u);
            echo $usermail;  
        ?>
      </td>
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