<?php
echo '<h1>Warranty List</h1>';

global $wpdb, $table_prefix;
$wp_warranty = $table_prefix.'warranty';
$wp_users = $table_prefix.'users';
if(isset($_GET['my_search_term'])){
    $q = "SELECT * FROM `$wp_warranty` WHERE `order_id` LIKE '%".$_GET['my_search_term']."%';";

}
else{
    $q = "SELECT * FROM `$wp_warranty`;";
}

//$q = "SELECT * FROM `$wp_warranty`;";
$results = $wpdb->get_results($q);
ob_start();
?>
<div class="wrap">
    <div class="my-form">
        <form action="<?php echo admin_url('admin.php'); ?>">
            <input type="hidden" name="page" value="warranty-page">
            <input type="text" name="my_search_term" id="my_search_term">
            <input type="submit" name="search" value="search">
        </form>
        <br />
    </div>
<table class="wp-list-table widefat fixed striped table-view-list posts front-tab">
   <thead>
      <th>Warranty ID</th>
      <th>User ID</th>
      <th>User Name</th>
      <th>User Email</td>
      <th>Amazon Order Id</th>
      <th>Order Date</th>
   </thead>
   <?php
   foreach($results as $result):
   ?>
   <tr>
      <td><?php echo $result->id ?></td>
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
            $u = "SELECT `user_email` FROM `$wp_users` WHERE `ID` = $result->user_id;";
            $usermail = $wpdb->get_var($u);
            echo $usermail;  
        ?>
      </td>
      <td><?php echo $result->order_id ?></td>
      <td><?php echo $result->purchase_date ?></td>
   </tr>
   <?php
   endforeach
   ?>
</table>

</div>

<?php
echo ob_get_clean();