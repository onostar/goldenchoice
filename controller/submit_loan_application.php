<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");
    $user = $_SESSION['user_id'];
    $store = $_SESSION['store_id'];
    $date = date("Y-m-d H:i:s");
    $customer = htmlspecialchars(stripslashes($_POST['customer']));
    $product = htmlspecialchars(stripslashes($_POST['product']));
    $asset = htmlspecialchars(stripslashes($_POST['asset']));
    $amount = htmlspecialchars(stripslashes($_POST['amount']));
    $purpose = ucwords(htmlspecialchars(stripslashes($_POST['purpose'])));
    $frequency = htmlspecialchars(stripslashes($_POST['frequency']));
    $installment = htmlspecialchars(stripslashes($_POST['installment']));
    $interest = htmlspecialchars(stripslashes($_POST['interest']));
    $interest_rate = htmlspecialchars(stripslashes($_POST['interest_rate']));
    $collateral = htmlspecialchars(stripslashes($_POST['collateral']));
    $processing = htmlspecialchars(stripslashes($_POST['processing_fee']));
    $processing_rate = htmlspecialchars(stripslashes($_POST['processing']));
    $total = htmlspecialchars(stripslashes($_POST['total_payable']));
    $loan_term = htmlspecialchars(stripslashes($_POST['loan_term']));
    $amount_request = number_format($amount, 2);
    include "../classes/dbh.php";
    include "../classes/inserts.php";
    include "../classes/select.php";
    $get_details = new selects();
    //get customer name
    $customer_details = $get_details->fetch_details_cond('customers', 'customer_id', $customer);
    if(is_array($customer_details)){
        foreach($customer_details as $detail){
            $customer_name = $detail->customer;
        }
    }
    //getproduct name
    $product_details = $get_details->fetch_details_cond('loan_products', 'product_id', $product);
    if(is_array($product_details)){ 
        foreach($product_details as $detail){
            $product_name = $detail->product;
        }
    }
    $data = array(
        'customer' => $customer,
        'product' => $product,
        'amount' => $amount,
        'purpose' => $purpose,
        'frequency' => $frequency,
        'installment' => $installment,
        'interest_rate' => $interest_rate,
        'interest' => $interest,
        'collateral' => $collateral,
        'processing_fee' => $processing,
        'processing_rate' => $processing_rate,
        'total_payable' => $total,
        'loan_term' => $loan_term,
        'asset' => $asset,
        'store' => $store,
        'posted_by' => $user,
        'application_date' => $date
    );
    $total = number_format($total, 2);
    $interest = number_format($interest, 2);
    $processing = number_format($processing, 2);
    $company = $_SESSION['company'];
    require "../PHPMailer/PHPMailerAutoload.php";
    require "../PHPMailer/class.phpmailer.php";
    require "../PHPMailer/class.smtp.php";
    $message = "<p>Dear Admin, <br> A new loan application has just been submitted by a user. Below are the application details:<br></p>
    <ul>
        <li><strong>Customer:</strong> $customer_name</li>
        <li><strong>Loan Product:</strong> $product_name</li>
        <li><strong>Requested Amount:</strong> NGN$amount_request</li>
        <li><strong>Purpose:</strong> $purpose</li>
        <li><strong>Loan Term:</strong> $loan_term Months</li>
        <li><strong>Repayment Frequency:</strong> $frequency</li>
        <li><strong>Installment:</strong> NGN$installment $frequency</li>
        <li><strong>Interest Rate:</strong> $interest_rate%</li>
        <li><strong>Interest:</strong> NGN$interest</li>
        <li><strong>Processing Fee:</strong> NGN$processing</li>
        <li><strong>Total Payable:</strong> NGN$total</li>
        <li><strong>Collateral:</strong> $collateral</li>
    </ul>
    <p>Kindly log in to the admin dashboard to review and process the application.<br><br>
    Best regards,<br>
    $company<br>Support Team</p>";
    //submitloan application
    $add_loan = new add_data('loan_applications', $data);
    $add_loan->create_data();
        
    if($add_loan){
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
        
        $to = 'contact@dorthprosuite.com';
        $from = 'admin@dorthprosuite.com';
        $from_name = "$customer_name";
        $name = "$company";
        $subj = 'New Loan Application Submitted';
        $msg = "<div>$message</div>";
        
        $error=smtpmailer($to, $from, $name ,$subj, $msg);
        echo "<div class='not_available'>
        <p><strong><i class='fas fa-check-circle' style='color: #28a745;'></i> Loan Application Submitted</strong><br>Your loan application has been submitted successfully. Kindly await approval and disbursement.</p></div>";
    }