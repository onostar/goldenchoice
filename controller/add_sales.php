<?php
// instantiate class
include "../classes/dbh.php";
include "../classes/select.php";
include "../classes/inserts.php";
    session_start();
    $store = $_SESSION['store_id'];
    $sales_type = "Loan sales";
    // $customer = 0;
    $date = date("Y-m-d H:i:s");
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        if(isset($_GET['invoice'])){
            $invoice = $_GET['invoice'];
        }
        if(isset($_GET['sales_item'])){
            $item = $_GET['sales_item'];
            $customer = $_GET['customer'];
            $loan = $_GET['loan'];
        }

    $quantity = 1;
    
    //get selling price
    $get_item = new selects();
    $rows = $get_item->fetch_details_cond('items', 'item_id', $item);
     if(gettype($rows) == 'array'){
        foreach($rows as $row){
            $price = $row->sales_price;
            $name = $row->item_name;
            $cost = $row->cost_price;
            // $department = $row->department;
        }
        //get quantity from inventory
        $get_qty = new selects();
        $qtyss = $get_qty->fetch_details_2cond('inventory', 'store', 'item', $store, $item);
        if(gettype($qtyss) == 'array'){
            foreach($qtyss as $qtys){
                $qty = $qtys->quantity;
            }
        }
        if(gettype($qtyss) == 'string'){
            $qty = 0;
        }
        $sales_cost = $quantity * $cost;
            if($qty == 0){
                /* echo "<div class='notify'><p><span>$name</span> has zero quantity! Cannot proceed</p>"; */
                echo "<script>
                    alert('$name has zero quantity! Cannot proceed');
                    </script>";
    include "sales_details.php";
            }else if($price == 0){
                echo "<div class='notify'><p><span>$name</span> does not have selling price! Cannot proceed</p></div>";
    include "sales_details.php";

            }else{
                 //insert into sales order
                $data = array(
                    'loan' => $loan,
                    'item' => $item,
                    'invoice' => $invoice,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total_amount' => $price,
                    'posted_by' => $user_id,
                    'cost' => $sales_cost,
                    'store' => $store,
                    'sales_type' => $sales_type,
                    'customer' => $customer,
                    'post_date' => $date,
                    // 'markup' => $markup
                );
                $sell_item = new add_data('sales', $data);
                $sell_item->create_data();
                if($sell_item){

        ?>
<!-- display sales for this invoice number -->
<div class="notify"><p><span><?php echo $name?></span> added to asset loan order</p></div>
<?php
    include "sales_details.php";
                }
            }
?>
   
    
<?php
         }
    }else{
        header("Location: ../index.php");
    } 
?>