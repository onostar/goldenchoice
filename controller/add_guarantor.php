<?php
    date_default_timezone_set("Africa/Lagos");
    session_start();
    $user = $_SESSION['user_id'];
    $store = $_SESSION['store_id'];
    $customer = htmlspecialchars(stripslashes($_POST['customer']));
    $guarantor = strtoupper(htmlspecialchars(stripslashes($_POST['full_name'])));
    $phone = htmlspecialchars(stripslashes($_POST['phone']));
    $address = ucwords(htmlspecialchars(stripslashes($_POST['address'])));
    $email = htmlspecialchars(stripslashes($_POST['email_add']));
    $gender = htmlspecialchars(stripslashes($_POST['gender']));
    $loan = htmlspecialchars(stripslashes($_POST['loan']));
    $occupation = htmlspecialchars(stripslashes($_POST['occupation']));
    $business = htmlspecialchars(stripslashes($_POST['business']));
    $biz_address = htmlspecialchars(stripslashes($_POST['business_address']));
    $relation = strtoupper(htmlspecialchars(stripslashes($_POST['relationship'])));
    $date = date("Y-m-d H:i:s");
    $todays_date = date("dmyh");
   
    $data = array(
        'client' => $customer,
        'full_name' => $guarantor,
        'loan' => $loan,
        'phone_number' => $phone,
        'email_address' => $email,
        'address' => $address,
        'gender' => $gender,
        'occupation' => $occupation,
        'relationship' => $relation,
        'business' => $business,
        'business_address' => $biz_address,
        'post_date' => $date,
        'posted_by' => $user,
    );
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/inserts.php";
    include "../classes/update.php";

   //check if guarantor exists
   
   $check = new selects();
   $results = $check->fetch_count_2cond('guarantors', 'loan', $loan, 'full_name', $guarantor);
   $results2 = $check->fetch_count_2cond('guarantors', 'loan', $loan, 'phone_number', $phone);
   if($results > 0 || $results2 > 0){
       echo "<div class='not_available'><p><strong><i class='fas fa-triangle-exclamation' style='color:rgb(214, 55, 7);'></i> Guarantor Already Exist</strong><br>$guarantor is already a guarantor for your current loan.</p></div>";
   }else{
        //create customer
        $add_data = new add_data('guarantors', $data);
        $add_data->create_data();
        if($add_data){
           echo "<div class='not_available'>
            <p><strong><i class='fas fa-check-circle' style='color: #28a745;'></i> Guarantor Added Successfully</strong><br>$guarantor has been added as a guarantor to your current loan.</p></div>";
        }
        
    }
   