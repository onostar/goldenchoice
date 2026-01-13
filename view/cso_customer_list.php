<?php

    include "../classes/dbh.php";
    include "../classes/select.php";


?>
    <div class="info"></div>
<div class="displays allResults" id="staff_list" style="width:90%!important;margin:50px auto!important">
    <h2>CSO Customer Lists</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchStaff" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    </div>
    <table id="room_list_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Full Name</td>
                <td>Customers</td>
                <td>Branch</td>
                <td>Date reg</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_details = new selects();
                $details = $get_details->fetch_details_cond('users', 'user_role', 'Loan Officer');
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><?php echo $detail->full_name?></td>
                <td style="color:var(--otherColor)">
                    <?php 
                        //get number of customers
                        $get_cust = new selects();
                        $custs = $get_cust->fetch_count_cond('customers', 'cso', $detail->user_id);
                        echo $custs;
                    ?>
                </td>
                <td style="color:var(--primaryColor)">
                    <?php 
                        //get store
                        $get_store = new selects();
                        $str = $get_store->fetch_details_group('stores', 'store', 'store_id', $detail->store);
                        echo $str->store;
                    ?>
                </td>
                <td><?php echo date("d-m-Y", strtotime($detail->reg_date))?></td>
                <td><a href="javascript:void(0)" onclick="showPage('view_cso_customer_list.php?cso=<?php echo $detail->user_id?>')" title="View customers" style="background:var(--tertiaryColor);color:#fff;box-shadow:1px 1px 1px #222; border:1px solid #fff; border-radius:10px; padding:4px">View <i class="fas fa-eye"></i></a></td>
                
            </tr>
            
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    
    <?php
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }
    ?>
</div>