<?php
if(isset($_GET['warranty_id'])){
    $warrentyid = $_GET['warranty_id'];
}

?>

<form action="https://ergonomc.com/raincloud-humidifier/activate-warranty/" method="post" class="wform">
    <input type="hidden" name="warranty_id" id="warranty_id" value="<?php echo $warrentyid ?>"  />
    <div>
        <label for="order_id" class="form-label">Details</label><br />
        <textarea id="description" name="description" rows="3"></textarea>
</div>
    <div>
        <input type="submit" value="Claim" name="wclaim">
    </div>
</form>