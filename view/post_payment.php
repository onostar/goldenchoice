<style>
    .not_available{
        width: 50%;
    }
    table td{
        padding:6px!important;
        font-size:.7rem!important;
    }
    /* table td p{
        padding:4px!important;
        font-size:.8rem!important;
    } */
    @media screen and (max-width: 800px){
        .not_available{
            width: 85%;
        }
        .inputs .data{
            width:48%!important;
            margin:0!important;
        }
        .inputs .data input{
            width:100%!important;
            margin:0!important;
        }
    }
</style>
<div id="loan_application">
<?php
    session_start();  
    date_default_timezone_set("Africa/Lagos");  
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(!isset($_SESSION['user_id'])) {
        header("Location: ../index.php");
        exit();
    }else{
        $customer = $_SESSION['client_id'];
        //check loan status
        $get_details = new selects();
        $existing = $get_details->fetch_details_2cond('loan_applications', 'customer', 'loan_status', $customer, 2);
        $no_loan = true;
        if(is_array($existing)){
            foreach($existing as $exist){
                $no_loan = false;
                //get loan product details
                $product_details = $get_details->fetch_details_cond('loan_products', 'product_id', $exist->product);
                if(is_array($product_details)){
                    foreach($product_details as $detail){
                        $product_name = $detail->product;
                    }
                }
                $request_date = $exist->application_date;
                $amount = $exist->amount;
                $total = $exist->total_payable;
                $processing = $exist->processing_fee;
                $interest = $exist->interest;
                $loan_term = $exist->loan_term." Months";
                $frequency = $exist->frequency;
                $due_date = $exist->due_date;
                $disbursed = $exist->disbursed_date;
            ?>
    <div class="not_available" style="width:90%">
        <section class="main_consult">
            <h3 style="background:#222; text-align:center; color:#fff; font-size:.9rem;padding:5px;">Current Loan Details</h3>
            <form action="" class="add_user_form" style="width:100%; margin:0; box-shadow:none;">
                <div class="inputs" style="display:flex; align-items:flex-end; flex-wrap:wrap; gap:.5rem; width:100%!important; margin:0;padding:15px; box-shadow:2px 2px 2px #c4c4c4;">
                    <div class="data" style="width:23%">
                        <label for="">Date Applied:</label>
                        <input type="text" value="<?php echo date("jS M, Y, H:ia", strtotime($request_date))?>" readonly>
                    </div>
                    <div class="data" style="width:23%">
                        <label for="">Disbursed Date:</label>
                        <input type="text" value="<?php echo date("jS M, Y, H:ia", strtotime($disbursed))?>" readonly>
                    </div>
                    <div class="data" style="width:23%">
                        <label for="">Amount Requested:</label>
                        <input type="text" value="<?php echo "₦".number_format($amount, 2)?>" readonly style="color:green">
                    </div>
                    <div class="data" style="width:23%">
                        <label for="">Interest:</label>
                        <input type="text" value="<?php echo "₦".number_format($interest, 2)?>" readonly style="color:var(--secondaryColor);">
                    </div>
                    <div class="data" style="width:23%">
                        <label for="">Transaction fee:</label>
                        <input type="text" value="<?php echo "₦".number_format($processing, 2)?>" readonly style="color:var(--primaryColor);">
                    </div>
                    <div class="data" style="width:23%">
                        <label for="">Total Repayable:</label>
                        <input type="text" value="<?php echo "₦".number_format($total, 2)?>" readonly>
                    </div>
                    <div class="data" style="width:23%">
                        <label for="">Repayment Term:</label>
                        <input type="text" value="<?php echo $loan_term?>" readonly>
                    </div>
                    <div class="data" style="width:23%">
                        <label for="">Repayment Frequency:</label>
                        <input type="text" value="<?php echo $frequency?>" readonly>
                    </div> 
                    
                </div>
            </form>
        </section>
        <section style="width:100%">
             <h3 style="background:var(--tertiaryColor); text-align:center; color:#fff; font-size:.9rem;padding:5px;"><?php echo $product_name?> Repayment Schedule</h3>
            <div class="displays allResults" style="width:100%!important; margin:0!important">
                <table id="item_list_table" class="searchTable">
                    <thead>
                        <tr style="background:var(--tertiaryColor)">
                            <td>S/N</td>
                            <td>Date</td>
                            <td>Amount Due</td>
                            <td>Amount Paid</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody id="result">
                        <?php
                            $n = 1;
                            $repays = $get_details->fetch_details_cond('repayment_schedule', 'loan', $exist->loan_id);
                            $allow_next = true; // True until first unpaid schedule is found
                            foreach($repays as $repay){
                        ?>
                        <tr>
                            <td style="text-align:center; color:red;"><?php echo $n?></td>
                            <td><?php echo date("d-M-Y", strtotime($repay->due_date))?></td>
                            <td style="color:var(--secondaryColor)"><?php  echo "₦".number_format($repay->amount_due, 2)?></td>
                            <td><?php  echo "₦".number_format($repay->amount_paid, 2)?></td>
                            <td>
                                <?php
                                    $date_due = new DateTime($repay->due_date);
                                    $today = new DateTime();

                                    $button = "<a style='border-radius:15px; background:var(--tertiaryColor);color:#fff; padding:3px 6px; box-shadow:1px 1px 1px #222; border:1px solid #fff' href='javascript:void(0)' onclick=\"showPage('client_payment.php?schedule={$repay->repayment_id}&customer={$customer}')\" title='Post payment'>Add Payment <i class='fas fa-hand-holding-dollar'></i></a>";

                                    if($repay->payment_status == "1"){
                                        echo "<span style='color:var(--tertiaryColor);'>Paid <i class='fas fa-check-circle'></i></span>";
                                    } else {
                                        // First unpaid schedule (or any overdue) is allowed to pay only if previous schedules are paid
                                        if($allow_next || $date_due < $today){
                                            if($date_due > $today){
                                                echo "<span style='color:var(--primaryColor);'><i class='fas fa-spinner'></i> Pending </span> {$button}";
                                            } else {
                                                echo "<span style='color:red;'><i class='fas fa-clock'></i> Overdue </span> {$button}";
                                            }
                                            $allow_next = false; // After showing Add Payment for one, others must wait
                                        } else {
                                            echo "<span style='color:#999;'>Waiting for previous payment <i class='fas fa-lock'></i></span>";
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        
                        <?php $n++; };?>
                    </tbody>
                </table>
                <?php
                    //get total due
                    $tls = $get_details->fetch_sum_single('repayment_schedule', 'amount_due', 'loan', $exist->loan_id);
                    foreach($tls as $tl){
                        $total_due = $tl->total;
                    }
                    //get total paid
                    $paids = $get_details->fetch_sum_single('repayment_schedule', 'amount_paid', 'loan', $exist->loan_id);
                    foreach($paids as $paid){
                        $total_paid = $paid->total;
                    }
                    $balance = $total_due - $total_paid;
                    ?>
                    <div class="totals" style="display:flex; gap:1rem; justify-content:right">
                        <?php
                        echo "<p class='total_amount' style='background:green; color:#fff; text-decoration:none; width:auto; float:right; padding:10px;font-size:1rem;'>Total Paid: ₦".number_format($total_paid, 2)."</p>";
                        echo "<p class='total_amount' style='background:red; color:#fff; text-decoration:none; width:auto; float:right; padding:10px;font-size:1rem;'>Total Due: ₦".number_format($balance, 2)."</p>";
                    ?>
                    </div>
                
            
            </div>
        </section>
    </div>
    <?php
                    
                
            }
        }
            if($no_loan){
            echo "<div class='not_available'>
                <p><strong><i class='fas fa-exclamation-triangle' style='color: #cfb20e;'></i> No Active Loan</strong><br>You currently have no Active Loan.</p></div>";
            }
        }
    ?>
</div>