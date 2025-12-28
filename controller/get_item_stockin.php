<?php
    session_start();
    $item = htmlspecialchars(stripslashes($_POST['item']));
    $store = $_SESSION['store_id'];
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    $vendor = htmlspecialchars(stripslashes($_POST['vendor']));
    $invoice = htmlspecialchars(stripslashes($_POST['invoice']));
    $_SESSION['vendor'] = $vendor;
    $_SESSION['purchase_invoice'] = $invoice;
    $get_item = new selects();
    // $rows = $get_item->fetch_details_likeNegCond('items', 'item_name', $item, 'item_type', 'Product');
    $rows = $get_item->fetch_items_quantity($store, $item);
     if(is_array($rows)){
        foreach($rows as $row):
       
    ?>
    <div class="results">
        <a href="javascript:void(0)" onclick="displayStockinForm('<?php echo $row->item_id?>')"><?php echo $row->item_name." (Quantity => ".$row->quantity.")"?></a>
    </div>
    
    
<?php
    endforeach;
     }else{
        echo "No resullt found";
     }
?>