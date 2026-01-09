<div id="loan_applications">
    <style>
        table td {
            font-size:.7rem;
        }
        .main_consult{
            margin: 10px 0;
        }
        @media screen and (max-width: 800px){
            .nomenclature .inputs .data{
                width:100%!important;
            }
            #prescriptions .inputs input, #prescriptions .inputs select{
                margin:0!important;
            }
        }
    </style>
<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
        if(isset($_GET['loan'])){
            $loan = $_GET['loan'];
            //get details
            $get_details = new selects();
            $rows = $get_details->fetch_details_cond('loan_applications', 'loan_id', $loan);
            foreach($rows as $row){
                //get customer details
                $cus = $get_details->fetch_details_cond('customers', 'customer_id', $row->customer);
                foreach($cus as $cu){
                    $customer_name = $cu->customer;
                    $acn = $cu->acn;
                    $phone = $cu->phone_numbers;
                    $gender = $cu->gender;
                    $address = $cu->customer_address.", ".$cu->lga.", ".$cu->state_region;
                    $photo = $cu->photo;
                    $income = $cu->income;
                }

?>
<a style="border-radius:15px; background:brown;color:#fff;padding:10px; box-shadow:1px 1px 1px #222; position:fixed;" href="javascript:void(0)" onclick="showPage('pending_applications.php')"><i class="fas fa-angle-double-left"></i> Return</a>
    <div id="patient_details">
        <h3 style="background:var(--tertiaryColor); color:#fff;">Loan Application Details</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="nomenclature">
            <div class="profile_foto">
                <img src="<?php echo '../photos/'.$photo?>" alt="Photo">
            </div>
            <div class="inputs">
                <div class="data">
                    <label for="customer">Full Name:</label>
                    <input type="text"value="<?php echo $customer_name?>" readonly>
                </div>
                
                <div class="data">
                    <label for="prn">Ledger No.:</label>
                    <input type="text" value="<?php echo $acn?>" readonly>
                   
                </div>
                <div class="data" style="width:30%">
                    <label for="phone_number">Phone number:</label>
                    <input type="text" required value="<?php echo $phone?>" readonly>
                </div>
                
                <div class="data" style="width:25%">
                    <label for="gender">Gender:</label>
                    <input type="text" value="<?php echo $gender?>">
                </div>
                 <div class="data" style="width:40%">
                    <label style="background:transparent; color:green; text-align:left; width:auto" for="other_names">Monthly Income (NGN):</label>
                    <input type="text"  value="<?php echo $income?>" readonly>
                
                </div>
                <div class="data" style="width:60%">
                    <label for="Address">Address:</label>
                    <textarea style="width:100%!important; padding:2px;border:none;" readonly><?php echo $address?></textarea>
                </div>
                <div class="data" style="width:auto!important">
                    <a style="border-radius:15px; background:var(--menuColor);color:#fff;padding:10px; box-shadow:1px 1px 1px #222; border:1px solid #fff;" href="javascript:void(0)" onclick="showPage('view_loan_customer_details.php?customer=<?php echo $row->customer?>&loan=<?php echo $loan?>')"><i class="fas fa-user-tag"></i> View More Details</a>

                </div>
            </div>
            
        </section>    
        
        <!-- loan details -->
        <section id="prescriptions">
            <div class="add_user_form" style="margin:0!important;width:100%!important">
                <h3 style="background:var(--menuColor);color:#fff;text-align:left">Loan Details</h3>
                <section style="text-align:left">
                    <div class="inputs" style="align-items:flex-end; justify-content:left; gap:.5rem">
                       <div class="data" style="width:32%;">
                            <label for="loan_name">Loan Product:</label>
                            <?php
                                $prods = $get_details->fetch_details_cond('loan_products', 'product_id', $row->product);
                                if(is_array($prods)){
                                    foreach($prods as $prod){
                                        $product_name = $prod->product;
                                    }
                                }
                            ?>
                            <input type="text" value="<?php echo $product_name?>" readonly>
                       </div>
                       <?php if($row->asset != 0){
                        //get details from sales
                        $itms = $get_details->fetch_details_cond('sales', 'loan', $loan);
                            if(is_array($itms)){
                                foreach($itms as $itm){
                                    $quantity = $itm->quantity;
                                    $asset_value = $itm->total_amount;
                                    $price = $itm->price;
                                }
                            }
                            $deposit = $asset_value - $row->amount;
                        ?>
                        <div class="data" style="width:32%;">
                            <label for="loan_name">Asset Product:</label>
                            <?php
                                $itms = $get_details->fetch_details_cond('items', 'item_id', $row->asset);
                                if(is_array($itms)){
                                    foreach($itms as $itm){
                                        $asset_name = $itm->item_name;
                                    }
                                }
                            ?>
                            <input type="text" value="<?php echo $asset_name?>" readonly>
                       </div>
                        <div class="data" style="width:32%;">
                            <label for="loan_name">Quantity:</label>
                            
                            <input type="text" value="<?php echo $quantity?>" readonly>
                       </div>
                        <div class="data" style="width:32%;">
                            <label for="loan_name">Unit Price:</label>
                            
                            <input type="text" value="<?php echo '₦'.number_format($price, 2)?>" readonly>
                       </div>
                        <div class="data" style="width:32%;">
                            <label for="loan_name">Total amount:</label>
                            
                            <input type="text" value="<?php echo '₦'.number_format($asset_value, 2)?>" readonly>
                       </div>
                        <div class="data" style="width:32%;">
                            <label for="loan_name">Deposit (NGN):</label>
                            
                            <input type="text" value="<?php echo '₦'.number_format($deposit, 2)?>" readonly>
                       </div>
                       <?php }?>
                        <div class="data" style="width:32%;">
                            <label for="amount" style="text-align:left!important;">Amount (₦)</label>
                            <input type="text" value="<?php echo '₦'.number_format($row->amount, 2)?>" readonly style="color:green">
                        </div>
                        <div class="data" style="width:32%;">
                            <label for="purpose" style="text-align:left!important;">Loan Purpose</label>
                            <input type="text" value="<?php echo $row->purpose?>" readonly>
                        </div>
                        
                        <div class="data" style="width:32%;">
                            <label for="duration" style="text-align:left!important;">Loan Term</label>
                            <input type="text" value="<?php echo $row->loan_term?> Months" readonly>
                        </div>
                        <div class="data" style="width:32%;">
                            <label for="repayment" style="text-align:left!important;">Repayment Frequency</label>
                            <input type="text" value="<?php echo $row->frequency?>" readonly>
                        </div>
                        <div class="data" style="width:32%;">
                            <label for="interest" style="text-align:left!important;">Interest: (<?php echo $row->interest_rate?>%)</label>
                            <input type="text" value="<?php echo '₦'.number_format($row->interest, 2)?>" readonly style="color:var(--secondaryColor)">
                        </div>
                        <div class="data" style="width:32%;">
                            <label for="processing"> Processing Fee: (<?php echo $row->processing_rate?>%)</label>
                            <input type="text" value="<?php echo '₦'.number_format($row->processing_fee, 2)?>" readonly style="color:var(--primaryColor)">
                        </div>
                        <div class="data" style="width:32%;">
                            <label for="">Total Repayable Amount:</label>
                            <input type="text" value="<?php echo '₦'.number_format($row->total_payable, 2)?>" readonly style="color:var(--tertiaryColor)">
                        </div>
                        <div class="data" style="width:32%;">
                            <label for=""><?php echo $row->frequency?> Installment:</label>
                            <input type="text" value="<?php echo '₦'.number_format($row->installment, 2)?>" readonly style="color:var(--otherColor)">
                        </div>
                        
                        <?php if($row->collateral == "Yes"){?>
                        <div class="data" style="width:64%;">
                            <label for="collateral"> Collateral Details</label>
                            <textarea readonly><?php echo $row->collateral?></textarea>
                        </div>
                        <?php }?>
                    </div>
                </section>   
            </div>
        </section>
        <section id="last_consult">
            <h3 style="background:var(--otherColor); text-align:left; color:#fff;">KYC Info</h3>
            <div class="nomenclature" style="box-shadow:none">
                
                <div class="inputs" style="width:100%; align-items:flex-end">
                    <!-- get kyc -->
                     <?php
                        $kycs = $get_details->fetch_details_cond('kyc', 'customer', $row->customer);
                        if(is_array($kycs)){
                            foreach($kycs as $kyc){
                                if($kyc->verification == 0){
                                    echo "<p style='text-align:center;font-size:.9rem;padding:5px;'>KYC is currently under verification.</p>";
                                }elseif($kyc->verification == -1){
                                    echo "<p style='text-align:center;font-size:.9rem;padding:5px;'>KYC was declined.</p>";
                                }else{
                     ?>
                    <div class="data" style="width:auto!important">
                        <label style="width:auto" for="other_names">ID Type:</label>
                        <input type="text"  value="<?php echo $kyc->id_type?>" readonly>
                    
                    </div>
                    <div class="data" style="width:auto!important">
                        <label style="width:auto" for="other_names">ID Number:</label>
                        <input type="text"  value="<?php echo $kyc->id_number?>" readonly>
                    
                    </div>
                    <div class="data" style="width:auto!important">
                        <label style="width:auto" for="other_names">BVN:</label>
                        <input type="text"  value="<?php echo $kyc->bvn?>" readonly>
                    
                    </div>
                    <div class="data">
                        <a style="border-radius:5px; background:silver;color:#222;padding:10px; box-shadow:1px 1px 1px #222; border:1px solid #fff;" href="../id_cards/<?php echo $kyc->id_card?>" target="_blank"><i class="fas fa-id-card"></i> View Identity Card</a>
                    </div>
                    <?php
                                }
                            }
                        }else{
                            echo "<p style='text-align:center;font-size:.9rem;padding:5px;'>No KYC available.</p>";
                        }
                    ?>
                   
                </div>
                 
            </div>
        </section>
        <?php
            //check for request
            $requests = $get_details->fetch_details_2cond('info_request', 'customer', 'loan', $row->customer, $loan);
            if(is_array($requests)){
                 
        ?>
        <section class="main_consult">
            <h3 style="background:transparent; text-align:left; color:#222; font-size:.8rem">Additional Information Requested</h3>
            <form action="" class="add_user_form" style="display:flex; width:100%; margin:0; align-items:flex-start;flex-wrap:wrap;gap:.5rem; box-shadow:none;">
                <?php
                    foreach($requests as $request){
                ?>
                <div class="inputs" style="display:flex; align-items:flex-end; flex-wrap:wrap; gap:.5rem; width:48%!important; margin:0;padding:15px; box-shadow:2px 2px 2px #c4c4c4;">
                    <div class="data" style="width:48%">
                        <label for="">Requested By:</label>
                        <?php
                            //get requested by
                            $names = $get_details->fetch_details_group('users', 'full_name', 'user_id', $request->requested_by);
                            $requester = $names->full_name;
                        ?>
                        <input type="text" value="<?php echo $requester?>" readonly>
                    </div>
                    <div class="data" style="width:48%">
                        <label for="">Request Date:</label>
                        <input type="text" value="<?php echo date("d-M-Y, H:i:sa", strtotime($request->request_date))?>" readonly>
                    </div>
                    <div class="data" style="margin:5px 0; width:100%">
                        <label for="">Request Details</label>
                        <textarea readonly><?php echo $request->request_text?></textarea>
                    </div>
                    
                </div>
                <?php }?>
            </form>
        </section>
        <?php
            //check documents
            $n = 1;
            $docs = $get_details->fetch_details_2cond('document_uploads', 'customer', 'loan', $row->customer, $loan);
            if(is_array($docs)){
        ?>
        <section class="main_consult" id="clientResponse">
             <h3 style="background:var(--menuColor); text-align:left; color:#fff; font-size:.8rem">Client's Additional Submissions</h3>
            <div class="displays allResults" style="width:100%!important; margin:0!important">
                <!-- <div class="search">
                    <input type="search" id="searchRoom" placeholder="Enter keyword" onkeyup="searchItems(this.value, 'search_patients.php')">
                </div> -->
                <table id="item_list_table" class="searchTable">
                    <thead>
                        <tr style="background:var(--moreColor)">
                            <td>S/N</td>
                            <td>Document Type</td>
                            <td>Title</td>
                            <td>Date</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="result">
                        <?php
                            foreach($docs as $doc){
                        ?>
                        <tr>
                            <td style="text-align:center; color:red;"><?php echo $n?></td>
                            <td><?php echo $doc->doc_type?></td>
                            <td><?php echo $doc->title?></td>
                            
                            <td style="color:var(--primaryColor)"><?php echo date("d-M-Y, h:ia", strtotime($doc->upload_date))?></td>
                            <td>
                                <a style="border-radius:15px; background:silver;color:#222;padding:3px 8px; box-shadow:1px 1px 1px #222; border:1px solid #fff; margin:2px" title="View Document" href="../documents/<?php echo $doc->document?>" target="_blank"><i class="fas fa-file-download"></i> View Document</a>
                            </td>
                        </tr>
                        
                        <?php $n++; };?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php
            }
            //check guaantors
            $n = 1;
            $guas = $get_details->fetch_details_2cond('guarantors', 'client', 'loan', $row->customer, $loan);
            if(is_array($guas)){
        ?>
        <section class="main_consult" id="clientResponse">
             <h3 style="background:var(--labColor); text-align:left; color:#fff; font-size:.8rem">Guarantors</h3>
            <div class="displays allResults" style="width:100%!important; margin:0!important">
                <!-- <div class="search">
                    <input type="search" id="searchRoom" placeholder="Enter keyword" onkeyup="searchItems(this.value, 'search_patients.php')">
                </div> -->
               <table id="priceTable" class="searchTable">
            <thead>
                <tr style="background:var(--labColor)">
                    <td>S/N</td>
                    <td>Loan Applied</td>
                    <td>Guarantor</td>
                    <td>Gender</td>
                    <td>Address</td>
                    <td>Phone No.</td>
                    <td>Email</td>
                    <td>Occupation</td>
                    <td>Business Name</td>
                    <td>Business Address</td>
                    <td>Relationship</td>
                </tr>
            </thead>

            
            <tbody>
            <?php
                foreach($guas as $gua):
                   
            ?>
                <tr>
                    <td style="text-align:center;"><?php echo $n?></td>
                    
                    <td>
                        <?php 
                            //get current loan
                            $cur_loan = $get_details->fetch_details_group('loan_applications', 'product', 'loan_id', $gua->loan);
                            $product = $cur_loan->product;
                            $loans = $get_details->fetch_details_cond('loan_products', 'product_id', $product);
                            foreach($loans as $ln){
                                echo $ln->product;
                            }
                        ?>
                    </td>
                    <td><?php echo $gua->full_name?></td>
                    <td><?php echo $gua->gender?></td>
                    <td>
                        <?php
                            echo $gua->address;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $gua->phone_number
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $gua->email_address;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $gua->occupation;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $gua->business;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $gua->business_address;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $gua->relationship;
                        ?>
                    </td>
                </tr>
            <?php $n++; endforeach;?>

            </tbody>

        </table>
            </div>
        </section>
        <?php }}?>
        <section id="requestBox">
            
        </section>
        <div class="nomenclature">
            <a style="border-radius:15px; background:var(--tertiaryColor);color:#fff; padding:5px; box-shadow:1px 1px 1px #222; border:1px solid #fff" href="javascript:void(0)" onclick="approveLoan('<?php echo $loan?>')" title="Approve loan application">Approve Loan <i class="fas fa-check-circle"></i></a>
            <a style="border-radius:15px; background:var(--primaryColor);color:#fff; padding:5px; box-shadow:1px 1px 1px #222; border:1px solid #fff" href="javascript:void(0)" onclick="requestMoreInfo('<?php echo $loan?>', '<?php echo $row->customer?>')" title="Request moreinformation">Request More Info <i class="fas fa-question-circle"></i></a>
            <a style="border-radius:15px; background:brown;color:#fff; padding:5px; box-shadow:1px 1px 1px #222; border:1px solid #fff" href="javascript:void(0)" onclick="declineLoan('<?php echo $loan?>')" title="Reject Loan application">Decline Loan <i class="fas fa-close"></i></a>
                        
        </div>
    </div>

<?php
            }
        }
    }else{
        header("Location: ../index.php");
    }
?>
</div>
