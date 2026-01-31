<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");
    $user = htmlspecialchars(stripslashes($_SESSION['user_id']));
    $withdrawal = htmlspecialchars(stripslashes($_POST['withdrawal']));
    
    $store = $_SESSION['store_id'];
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/inserts.php";
    include "../classes/update.php";
    include "../classes/delete.php";


    $delete = new deletes();
    $delete->delete_item('withdrawals', 'withdrawal_id', $withdrawal);


        echo "<div class='success'><p style='color:brown'>Withdrawal request declined successfully! Customer Account updated <i class='fas fa-thumbs-down'></i></p></div>";
    
