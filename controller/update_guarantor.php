<?php
   
    $id = htmlspecialchars(stripslashes($_POST['item_id']));
    $guarantor = strtoupper(htmlspecialchars(stripslashes($_POST['full_name'])));
    $phone = htmlspecialchars(stripslashes($_POST['phone']));
    $address = ucwords(htmlspecialchars(stripslashes($_POST['address'])));
    $email = htmlspecialchars(stripslashes($_POST['email_add']));
    $gender = htmlspecialchars(stripslashes($_POST['gender']));
    $occupation = htmlspecialchars(stripslashes($_POST['occupation']));
    $business = htmlspecialchars(stripslashes($_POST['business']));
    $biz_address = htmlspecialchars(stripslashes($_POST['business_address']));
    $relation = strtoupper(htmlspecialchars(stripslashes($_POST['relationship'])));
   
    $data = array(
        'full_name' => $guarantor,
        'phone_number' => $phone,
        'email_address' => $email,
        'address' => $address,
        'gender' => $gender,
        'occupation' => $occupation,
        'relationship' => $relation,
        'business' => $business,
        'business_address' => $biz_address,
    );
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/update.php";

   //check if guarantor exists
   
   /* $check = new selects();
   $results = $check->fetch_count_2cond('guarantors', 'loan', $loan, 'full_name', $guarantor);
   $results2 = $check->fetch_count_2cond('guarantors', 'loan', $loan, 'phone_number', $phone);
   if($results > 0 || $results2 > 0){
       echo "<div class='not_available'><p><strong><i class='fas fa-triangle-exclamation' style='color:rgb(214, 55, 7);'></i> Guarantor Already Exist</strong><br>$guarantor is already a guarantor for your current loan.</p></div>";
   }else{ */
        //update gurantor
    $update = new Update_table();
    $update->updateAny('guarantors', $data, 'guarantor_id', $id);
    if($update){
        echo "<div class='not_available'>
        <p><strong><i class='fas fa-check-circle' style='color: #28a745;'></i> Guarantor Updated Successfully</strong><br>$guarantor details has been updated successfully</p></div>";
    }
        
    
   