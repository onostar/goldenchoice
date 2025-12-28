<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        $user = $_SESSION['user_id'];
?>
<div id="package">
<style>
    table td {
        font-size:.7rem;
    }
</style>
<?php
    include "../classes/dbh.php";
    include "../classes/select.php";
    
    if(isset($_SESSION['success'])){
        echo $_SESSION['success'];
    }
    //get customer details
    $get_customer = new selects();
    $rows = $get_customer->fetch_details_cond('customers', 'user_id', $user);
    foreach($rows as $row){
        $customer_id = $row->customer_id;
    }
?>

    <div class="info" style="margin:0!important; width:90%!important"></div>
    <div class="displays allResults" style="width:100%;">
    
        <h2>List Of Guarantors</h2>
        <hr>
        <div class="search">
            <input type="search" id="searchGuestPayment" placeholder="Enter keyword" onkeyup="searchData(this.value)">
            <a style="border-radius:15px; background:brown;color:#fff;padding:5px; box-shadow:1px 1px 1px #222; border:1px solid #fff; margin:10px;"href="javascript:void(0)" onclick="showPage('add_guarantor.php')" title="Add new loan product"><i class="fas fa-plus"></i> Add Guarantor</a>
        </div>
        <table id="priceTable" class="searchTable">
            <thead>
                <tr style="background:var(--labColor)">
                    <td>S/N</td>
                    <td>Loan Applied</td>
                    <td>Guarantor</td>
                    <td>Address</td>
                    <td>Phone No.</td>
                    <td>Email</td>
                    <td>Occupation</td>
                    <td>Business Name</td>
                    <td>Business Address</td>
                    <td>Relationship</td>
                    <td></td>
                </tr>
            </thead>

            
            <tbody>
            <?php
                $n = 1;
                $select_cat = new selects();
                $rows = $select_cat->fetch_details_condOrder('guarantors', 'client', $customer_id, 'full_name');
                if(gettype($rows) == "array"){
                    foreach($rows as $row):
                   
            ?>
                <tr>
                    <td style="text-align:center;"><?php echo $n?></td>
                    
                    <td>
                        <?php 
                            //get current loan
                            $cur_loan = $select_cat->fetch_details_group('loan_applications', 'product', 'loan_id', $row->loan);
                            $product = $cur_loan->product;
                            $loans = $select_cat->fetch_details_cond('loan_products', 'product_id', $product);
                            foreach($loans as $ln){
                                echo $ln->product;
                            }
                        ?>
                    </td>
                    <td><?php echo $row->full_name?></td>
                    <td>
                        <?php
                            echo $row->address;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row->phone_number
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row->email_address;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row->occupation;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row->business;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row->business_address;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row->relationship;
                        ?>
                    </td>
                    <td>
                        <a style="background:var(--tertiaryColor)!important; color:#fff!important; padding:3px 6px; margin:2px;border-radius:50%; border:1px solid #fff; box-shadow:1px 1px 1px #222" title="update details" href="javascript:void(0)" onclick="getForm('<?php echo $row->guarantor_id?>', 'get_guarantor.php');"><i class="fas fa-pen"></i></a>
                        
                        
                        
                    </td>
                </tr>
            <?php $n++; endforeach; }?>

            </tbody>

        </table>
        
        <?php
            if(gettype($rows) == "string"){
                echo "<p class='no_result'>'$rows'</p>";
            }
        ?>
    </div>
    
</div>
<?php 
    }else{
        header("Location: ../index.php");
    }
?>