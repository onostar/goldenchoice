<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");;
    $user = $_SESSION['user_id'];
    $date = date("Y-m-d H:i:s");
    $loan = htmlspecialchars(stripslashes($_POST['loan']));
    $reason = ucwords(htmlspecialchars(stripslashes($_POST['reason'])));
    $company = $_SESSION['company'];
    
    include "../classes/dbh.php";
    include "../classes/inserts.php";
    include "../classes/select.php";
    include "../classes/delete.php";
    include "../classes/update.php";
    // include "../classes/update.php";

    $get_details = new selects();
    //get loan details
    $results = $get_details->fetch_details_cond('loan_applications', 'loan_id', $loan);
    foreach($results as $result){
        $customer = $result->customer;
        $product = $result->product;
    }
    //get customer name
    $customer_details = $get_details->fetch_details_cond('customers', 'customer_id', $customer);
    if(is_array($customer_details)){
        foreach($customer_details as $detail){
            $customer_name = $detail->customer;
            $customer_mail = $detail->customer_email;
        }
    }
    //get product name
    $product_details = $get_details->fetch_details_cond('loan_products', 'product_id', $product);
    if(is_array($product_details)){ 
        foreach($product_details as $detail){
            $product_name = $detail->product;
        }
    }
     //insert into notifications
        $notif_data = array(
            'client' => $customer,
            'subject' => 'Loan Application Declined',
            'message' => 'Dear '.$customer_name.', 
            Thank you for choosing '. $company .' for your financial needs.
            
            After careful review of your recent loan application, we regret to inform you that your request has not been approved at this time. This decision was based on our internal assessment and current lending criteria.
            
            Your application was declined for the following reasons:
            '.$reason.'
            
            We understand this may be disappointing, and we encourage you to reapply in the future or reach out to us to discuss possible alternatives or ways to strengthen your eligibility.
            
            Thank you once again for considering '.$company. '
            
            Warm regards,
            '.$company,
            'post_date' => $date,
        );
        
    require "../PHPMailer/PHPMailerAutoload.php";
    require "../PHPMailer/class.phpmailer.php";
    require "../PHPMailer/class.smtp.php";
    $message = "<p>Dear $customer_name, <br> Thank you for choosing $company for your financial needs.<br><br>After careful review of your recent loan application, we regret to inform you that your request has not been approved at this time. This decision was based on our internal assessment and current lending criteria.<br><br>  Your application was declined for the following reasons: <br><strong>$reason</strong>.<br><br>We understand this may be disappointing, and we encourage you to reapply in the future or reach out to us to discuss possible alternatives or ways to strengthen your eligibility.<br><br>If you would like more details regarding the reason for this decision or need assistance with future applications, please don’t hesitate to contact us.<br><br>Thank you once again for considering $company.<br><br>
    Warm regards,
    $company</p>";
    
    //delete loan applications
    $delete_loan = new deletes();
    /*$delete_loan->delete_item('loan_applications', 'loan_id', $loan); */
    //update loan status to negative
    $update = new Update_table();
    $update->update_tripple('loan_applications', 'loan_status', '-1', 'approve_date', $date, 'approved_by', $user, 'loan_id', $loan);
    if($update){
        //insert notification
        $add_data = new add_data('notifications', $notif_data);
        $add_data->create_data();
        //delete guarantors and documents with loan id
        $tables = $get_details->fetch_tables('microfinance');
        foreach($tables as $table){
            //check for loan column exist in each table and delete it when the number is seen
            $check_column = new selects();
            $cols = $check_column->fetch_column($table->table_name, 'loan');
            if($cols){
                $delete_loan->delete_item($table->table_name, 'loan', $loan);
            }
            
        }
        /* send mails to customer */
        function smtpmailer($to, $from, $from_name, $subject, $body){
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; 
    
            $mail->SMTPSecure = 'ssl'; 
            $mail->Host = 'www.dorthprosuite.com';
            $mail->Port = 465; 
            $mail->Username = 'admin@dorthprosuite.com';
            $mail->Password = 'yMcmb@her0123!';   
    
            $mail->IsHTML(true);
            $mail->From="admin@dorthprosuite.com";
            $mail->FromName=$from_name;
            $mail->Sender=$from;
            $mail->AddReplyTo($from, $from_name);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AddAddress($to);
            $mail->AddAddress('onostarmedia@gmail.com');
            
            if(!$mail->Send())
            {
                $error = "Failed to send mail";
                
                return $error; 
            }
            else 
            {
                
                /* success message */
                
                $error = "Message Sent Successfully";
                
                // header("Location: index.html");
                return $error;
            }
        }
        
        $to = $customer_mail;
        $from = 'admin@dorthprosuite.com';
        $from_name = "$company";
        $name = "$company";
        $subj = 'Loan Application Declined';
        $msg = "<div>$message</div>";
        
        $error=smtpmailer($to, $from, $name ,$subj, $msg);
        ?>
        <div class='not_available'>
        <p><i class='fas fa-check-circle' style='color: red;'></i> Loan Application Declined Successfully</p><br>
        <a href="javascript:void(0)" style="padding:5px;background:var(--tertiaryColor);color:#fff;box-shadow:1px 1px 1px #222; text-align:center;" onclick="showPage('../view/pending_applications.php')"> Continue <i class="fas fa-paper-plane"></i></a></div>
    <?php
    }