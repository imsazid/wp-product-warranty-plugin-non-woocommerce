<?php
if(isset($_POST['wregister'])){
    global $wpdb,$table_prefix;
    $wp_warranty = $table_prefix.'warranty';
    $orderid = $wpdb->escape($_POST['order_id']);
    $orderdate = $wpdb->escape($_POST['purchase_date']);
    $userid = get_current_user_id();

    $data = array(
        'user_id' => $userid,
        'order_id' => $orderid,
        'purchase_date' => $orderdate,
    
    );
    
    $wpdb->insert($wp_warranty, $data);
}



?>

<form action="<?php echo get_the_permalink(); ?>" method="post" class="wform">
    <div class="um-left um-half">
        <label for="order_id" class="form-label">Amazon Order ID</label><br />
        <input type="text" id="order_id" name="order_id" placeholder="112-23345-89056" />
    </div>
    <div class="um-left um-half">
        <label for="purchase_date" class="form-label">Order Date</label><br />
        <input type="date" id="purchase_date" name="purchase_date" />
    </div>
    <div>
        <input type="submit" value="Register" name="wregister">
    </div>
</form>