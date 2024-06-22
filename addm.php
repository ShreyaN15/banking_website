<?php 
include('header.php'); 

// Ensure the database connection is established
$dbservername = "localhost"; 
$dbusername = "root"; 
$dbpassword = ""; 
$dbname = "banking_system"; 

$con = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if(mysqli_connect_errno()) { 
    echo "<div style='color:#fff;'>Connection failed: " . mysqli_connect_error() . "</div>"; 
    exit(); 
} 
?>
<div class="wrapper"> 
    <a href="index.php">Home</a> 
    <div class="container"> 
        <h4>Transfer Money</h4> 
        <form action="" method="POST"> 
            <input type="number" name="from_account_id" placeholder="From Account ID" required><br> 
            <input type="number" name="to_account_id" placeholder="To Account ID" required><br> 
            <input type="number" name="amount" placeholder="Amount" required><br> 
            <input type="submit" name="submit" value="Transfer Money"> 
        </form> 
    </div> 
</div> 
<?php
if(isset($_POST['submit'])) { 
    $from_account_id = $_POST['from_account_id']; 
    $to_account_id = $_POST['to_account_id']; 
    $amount = $_POST['amount']; 

    // Check if both accounts exist and if the from_account has enough balance
    $fromAccountQuery = mysqli_query($con, "SELECT balance FROM accounts WHERE id='$from_account_id'");
    $toAccountQuery = mysqli_query($con, "SELECT id FROM accounts WHERE id='$to_account_id'");

    if(mysqli_num_rows($fromAccountQuery) > 0 && mysqli_num_rows($toAccountQuery) > 0) {
        $fromAccount = mysqli_fetch_assoc($fromAccountQuery);
        if($fromAccount['balance'] >= $amount) {
            // Begin transaction
            mysqli_begin_transaction($con);
            try {
                // Deduct amount from from_account
                $deductQuery = mysqli_query($con, "UPDATE accounts SET balance = balance - '$amount' WHERE id='$from_account_id'");
                if(!$deductQuery) {
                    throw new Exception(mysqli_error($con));
                }

                // Add amount to to_account
                $addQuery = mysqli_query($con, "UPDATE accounts SET balance = balance + '$amount' WHERE id='$to_account_id'");
                if(!$addQuery) {
                    throw new Exception(mysqli_error($con));
                }

                // Commit transaction
                mysqli_commit($con);
                echo "<div class='status'>Money transferred successfully</div>";
            } catch (Exception $e) {
                // Rollback transaction
                mysqli_rollback($con);
                echo "<div class='status'>Error during transfer: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='status'>Insufficient balance in the source account</div>";
        }
    } else {
        echo "<div class='status'>One or both account IDs are invalid</div>";
    }
}
?> 
</body> 
</html>
