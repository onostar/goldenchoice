<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");;
    $user = $_SESSION['user_id'];
    $date = date("Y-m-d H:i:s");
    $customer = htmlspecialchars(stripslashes($_POST['customer']));
    $loan = htmlspecialchars(stripslashes($_POST['loan']));
    $request = ucwords(htmlspecialchars(stripslashes($_POST['request_text'])));
    
    include "../classes/dbh.php";
    include "../classes/inserts.php";
    include "../classes/select.php";
    $get_details = new selects();
    //get customer name
    $customer_details = $get_details->fetch_details_cond('customers', 'customer_id', $customer);
    if(is_array($customer_details)){
        foreach($customer_details as $detail){
            $customer_name = $detail->customer;
            $customer_mail = $detail->customer_email;
        }
    }
    //get loan details
    $loans = $get_details->fetch_details_group('loan_applications', 'product','loan_id', $loan);
    $product = $loans->product;
    //getproduct name
    $product_details = $get_details->fetch_details_cond('loan_products', 'product_id', $product);
    if(is_array($product_details)){ 
        foreach($product_details as $detail){
            $product_name = $detail->product;
        }
    }
    $company = $_SESSION['company'];
    require "../PHPMailer/PHPMailerAutoload.php";
    require "../PHPMailer/class.phpmailer.php";
    require "../PHPMailer/class.smtp.php";
    $message = "<p>Dear $customer_name, <br> We hope this message finds you well.<br>As part of the review process for your $product_name application, we kindly require additional information to proceed.</p>
    <h3>Requested Information:</h3>
    <p>$request</p>
    <p>Please log in to your account to respond to this request as soon as possible. This will help us continue processing your loan application without delay.<br><a href='demo.dorthprosuite.com' title='login' style='background:green;color:#fff;padding:5px;'>Login</a></p>
    <p>If you have any questions, feel free to reach out to our support team.<br><br>Thank you for choosing $company. We look forward to supporting your financial needs
    Best regards,<br><strong>The Loan Review Team</strong><br>$company</p>";
    $data = array(
        'customer' => $customer,
        'loan' => $loan,
        'request_text' => $request,
        'requested_by' => $user,
        'request_date' => $date
    );
    //insert into notifications
    $notif_data = array(
        'client' => $customer,
        'subject' => 'Action Required: Additional Information Needed for Your Loan Application',
        'message' => 'Dear '.$customer_name.', 
         We hope this message finds you well.
         As part of the review process for your '.$product_name.' application, we kindly require additional information to proceed.
         
        Requested Information:
        '.$request.'
        
        Please respond to this request as soon as possible. This will help us continue processing your loan application without delay.
        
        If you have any questions, feel free to reach out to our support team.
        
        Thank you for choosing '.$company.' We look forward to supporting your financial needs.
        
        Best regards,
        The Loan Review Team
        '.$company,
        'post_date' => $date,
    );
    $add_notif = new add_data('notifications', $notif_data);
    $add_notif->create_data();
    
    $send_request = new add_data('info_request', $data);
    $send_request->create_data();
    
    if($send_request){
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
        $subj = 'Action Required: Additional Information Needed for Your Loan Application';
        $msg = "<div>$message</div>";
        
        $error=smtpmailer($to, $from, $name ,$subj, $msg);
        echo "<div class='not_available'>
        <p><strong><i class='fas fa-check-circle' style='color: #28a745;'></i> Request Sent Successfully</strong></p></div>";
    }