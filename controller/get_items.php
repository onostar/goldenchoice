<?php
    session_start();
    $store = $_SESSION['store_id'];
    $item = htmlspecialchars(stripslashes($_POST['item']));
    $loan = htmlspecialchars(stripslashes($_POST['loan']));
    $customer = htmlspecialchars(stripslashes($_POST['customer']));
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_item = new selects();
    $rows = $get_item->fetch_items_quantity($store, $item);
     if(gettype($rows) == 'array'){
        foreach($rows as $row):
            
        
    ?>
    
    <div class="results">
        <a href="javascript:void(0)" onclick="showPage('asset_loan_application.php?asset=<?php echo $row->item_id?>&product=<?php echo $loan?>&customer=<?php echo $customer?>')"><?php echo $row->item_name." (Price => ₦".$row->sales_price.", Qty => ".$row->quantity.")"?></a>
    </div>
<?php
    endforeach;
     }else{
        echo "No resullt found";
     }
?>