<!-- <?php

    /* include "../classes/dbh.php";
    include "../classes/select.php"; */


?>
    <div class="info"></div>
<div class="displays allResults" id="staff_list" style="width:90%!important;margin:50px auto!important">
    <h2>Customer list</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchStaff" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    </div>
    <table id="room_list_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Customer name</td>
                <td>Ledger No.</td>
                <td>Phone number</td>
                <td>Address</td>
                <td>Email</td>
                <td>Balance</td>
                <td>Date reg</td>
            </tr>
        </thead>
        <tbody>
            <?php
                /* $n = 1;
                $get_details = new selects();
                $details = $get_details->fetch_details_order('customers', 'customer');
                if(gettype($details) === 'array'){
                foreach($details as $detail): */
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><?php echo $detail->customer?></td>
                <td><?php echo $detail->acn?></td>
                <td><?php echo $detail->phone_numbers?></td>
                <td><?php echo $detail->customer_address?></td>
                <td><?php echo $detail->customer_email?></td>
                <?php /* if($detail->wallet_balance >= 0){ */ ?>
                <td style="color:green"><?php echo "₦".number_format($detail->wallet_balance, 2);?>
                </td>
                <?php /* }else{ */?>
                <td style="color:red"><?php echo "₦".number_format($detail->wallet_balance * (-1), 2);?>
                <td style="color:red">
                    <?php 
                       /*  $fetch_bal = new selects();
                        $bals = $fetch_bal->fetch_account_balance($detail->acn);
                        foreach($bals as $bal){
                            $wallet_balance = $bal->balance;
                        }
                        echo "₦".number_format($wallet_balance, 2); */
                    ?>
                <?php /* } */?>
                </td>
                <td><?php echo date("d-m-Y", strtotime($detail->reg_date))?></td>
                
                
            </tr>
            
            <?php /* $n++; endforeach;} */?>
        </tbody>
    </table>
    
    <?php
        /* if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        } */
    ?>
</div> -->
<?php
session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    //pagination
    if(!isset($_GET['page'])){
        $page_number = 1;
    }else{
        $page_number = $_GET['page'];
    }
    //set limit
    $limit = 50;
    //calculate offset
    $offset = ($page_number - 1) * $limit;
    $prev_page = $page_number - 1;
    $next_page = $page_number + 1;
    $adjacents = "2";
    //get number of pages
    $get_pages = new selects();
    $pages = $get_pages->fetch_count('customers');
    $total_pages = ceil($pages/$limit);
    //get second to last page
    $second_to_last = $total_pages - 1;

    //get user
    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        //get user role
        $get_role = new selects();
        $roles = $get_role->fetch_details_group('users', 'user_role', 'username', $username);
        $role = $roles->user_role;

?>
    <!-- filter by category -->
    <!-- <div class="filter">
        <label for="Filter">Filter by Sponsor</label><br>
        <select name="filter" id="filter" onchange="filterItems(this.value)">
            <option value="" selected>Select sponsor</option>
           
             <option value="0">PRIVATE</option>
            <?php
                /* $get_cat = new selects();
                $cats = $get_cat->fetch_details('sponsors');
                foreach($cats as $cat){ */
            ?>
            <option value="<?php echo $cat->sponsor_id?>"><?php echo $cat->sponsor?></option>
            <?php /* } */?>
        </select>
    </div> -->
    <div class="info"></div>
<div class="displays allResults" id="bar_items">
    
    <h2>Client List</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRoom" placeholder="Enter keyword" onkeyup="searchItems(this.value, 'search_patients.php')">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('item_list_table', 'List of Clients')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="item_list_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Client name</td>
                <td>Ledger No.</td>
                <td>Phone number</td>
                <td>Address</td>
                <td>Email</td>
                <!-- <td>Balance</td> -->
                <td>Date reg</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="result">
        <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_pageOrder('customers', $limit, $offset, 'customer');
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><?php echo $detail->customer?></td>
                <td><?php echo $detail->acn?></td>
                <td><?php echo $detail->phone_numbers?></td>
                <td><?php echo $detail->customer_address?></td>
                <td><?php echo $detail->customer_email?></td>
                <?php /* if($detail->wallet_balance >= 0){ */ ?>
                <!-- <td style="color:green"><?php echo "₦".number_format($detail->wallet_balance, 2);?>
                </td> -->
                <?php /* }else{ */?>
                <!-- <td style="color:red"><?php echo "₦".number_format($detail->wallet_balance * (-1), 2);?> -->
                <!-- <td style="color:red">
                    <?php 
                        /* $fetch_bal = new selects();
                        $bals = $fetch_bal->fetch_account_balance($detail->acn);
                        foreach($bals as $bal){
                            $wallet_balance = $bal->balance;
                        }
                        echo "₦".number_format($wallet_balance, 2); */
                    ?>
                <?php /* } */?>
                </td> -->
                <td><?php echo date("d-m-Y", strtotime($detail->reg_date))?></td>
                
                <td>
                    <a style="padding:5px; border-radius:15px;background:var(--tertiaryColor);color:#fff;"href="javascript:void(0)" onclick="showPage('view_customer_details.php?customer=<?php echo $detail->customer_id?>')" title="view patient details">view <i class="fas fa-eye"></i></a>
                </td>
            </tr>
            
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    <div class="page_links">
        <?php
            if(gettype($details) == "array"){
                echo "<p><strong>Pages ".$page_number." of ".$total_pages."</strong></p>";
        ?>
        <ul class="pages">
            <?php
                if($page_number > 1){
            ?>
                <li><a href="javascript:void(0)" onclick="showPage('customer_list.php?page=1')"title="Go to first page"><< First page</a></li>
                <li><a href="javascript:void(0)" onclick="showPage('customer_list.php?page=<?php echo $previous_page?>')"title="Go to previous page">< Previous</a></li>
            <?php
            }
                if($page_number < $total_pages){
                   
            ?>
                <li><a href="javascript:void(0)" onclick="showPage('customer_list.php?page=<?php echo $next_page?>')" title="Go to next page">Next ></a></li>
                <li><a href="javascript:void(0)" onclick="showPage('customer_list.php?page=<?php echo $total_pages?>')" title="Go to last page">Last Page >></a></li>
                <?php }?>
        </ul>
        <?php }?>
    </div>
    <?php
        
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }
    
    ?>
</div>
<?php }?>