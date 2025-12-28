<?php
    session_start();
    $store = $_SESSION['store_id'];
    $item = htmlspecialchars(stripslashes($_POST['item']));
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
            <a href="javascript:void(0)" onclick="addWholeSales('<?php echo $row->item_id?>')"><?php echo $row->item_name." (Price => ₦".$row->sales_price.", Quantity => ".$row->quantity.")"?></a>
        </div>
<?php
    // }
    endforeach;
     }else{
        echo "No result found";
     }
?>