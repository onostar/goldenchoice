
<?php
session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    
    //get user
    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        $cso = $_SESSION['user_id'];
        //get user role
        $get_role = new selects();
        $roles = $get_role->fetch_details_group('users', 'user_role', 'username', $username);
        $role = $roles->user_role;

?>
   
    <div class="info"></div>
<div class="displays allResults" id="bar_items">
    
    <h2>My Client List</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRoom" placeholder="Enter keyword" onkeyup="searchData(this.value)">
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
                <td>Date reg</td>
                <td></td>
            </tr>
        </thead>
        <tbody id="result">
        <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_condOrder('customers', 'cso', $cso, 'customer');
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
               
                <td>
                    <?php if($detail->debt_balance > 0){?>
                    <a style="padding:5px; border-radius:15px;background:var(--otherColor);color:#fff;"href="javascript:void(0)" onclick="showPage('pay_outstanding.php?customer=<?php echo $detail->customer_id?>')" title="Pay outstanding debt">Post <i class="fas fa-hand-holding-dollar"></i></a>
                    <?php }else{?>
                    <a style="padding:5px; border-radius:15px;background:var(--otherColor);color:#fff;"href="javascript:void(0)" onclick="showPage('customer_repayment.php?customer=<?php echo $detail->customer_id?>')"title="post loan payment">Post <i class="fas fa-hand-holding-dollar"></i></a>
                    <?php } ?>
                </td>
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