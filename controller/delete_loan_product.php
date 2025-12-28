<?php
        session_start();
    if(isset($_GET['item'])){
        $item = $_GET['item'];
        // instantiate classes
        include "../classes/dbh.php";
        include "../classes/select.php";
        include "../classes/delete.php";

        $delete = new deletes();
        $delete->delete_item('loan_products', 'product_id', $item);
        if($delete){
            echo "<div class='success'><p>Loan Product deleted successfully! <i class='fas fa-thumbs-up'></i></p></div>";
        }else{
            echo "<p class='exist'>Failed to delete product <i class='fas fa-thumbs-down'></i></p>";
        }
    }else{
        echo "<p class='exist'>No product selected for deletion</p>";
    }          
        
    
?>