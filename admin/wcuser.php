<?php
echo '<h1>Users List</h1>';

global $wpdb, $table_prefix;
$wp_users = $table_prefix.'users';
if(isset($_GET['my_search_term'])){
    $q = "SELECT * FROM `$wp_users` WHERE `dispay_name` LIKE '%".$_GET['my_search_term']."%';";

}
else{
    $q = "SELECT * FROM `$wp_users`;";
}

//$q = "SELECT * FROM `$wp_warranty`;";
$results = $wpdb->get_results($q);
ob_start();
?>
<div class="wrap">
    <div class="my-form">
        <form action="<?php echo admin_url('admin.php'); ?>">
            <input type="hidden" name="page" value="wcuser">
            <input type="text" name="my_search_term" id="my_search_term">
            <input type="submit" name="search" value="search">
        </form>
        <br />
    </div>
<table class="wp-list-table widefat fixed striped table-view-list posts">
   <thead>
      <th>User ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Joined Date</th>
   </thead>
   <?php
   foreach($results as $result):
   ?>
   <tr>
      <td><?php echo $result->ID ?></td>
      <td><?php echo $result->display_name ?></td>
      <td><?php echo $result->user_email ?></td>
      <td><?php echo $result->user_registered ?></td>
      <td></td>
   </tr>
   <?php
   endforeach
   ?>
</table>

</div>

<?php
echo ob_get_clean();