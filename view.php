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
        <h4>Search Account</h4> 
        <form action="" method="POST"> 
            <input type="text" name="account_id" placeholder="Account ID" required><br> 
            <input type="submit" name="sbtBtn" value="Search"> 
        </form> 
    </div> 
</div> 
<?php 
if(isset($_POST['sbtBtn'])) { 
    $account_id = mysqli_real_escape_string($con, $_POST['account_id']); 

    // Query to fetch account details
    $getDetailsQuery = mysqli_query($con, "SELECT * FROM accounts WHERE id='$account_id'"); 

    if(mysqli_num_rows($getDetailsQuery) == 0) { 
        echo "<div class='result'>Account not found</div>"; 
    } else { 
        $getDetails = mysqli_fetch_array($getDetailsQuery); 
        $name = $getDetails['name']; 
        $balance = $getDetails['balance']; 
        $dob = $getDetails['dob']; 
        $account_type = $getDetails['account_type']; 
        echo "<div class='result'> 
            <div class='ind'>Name: " . $name . "</div> 
            <div class='ind'>Account ID: " . $account_id . "</div> 
            <div class='ind'>Balance: " . $balance . "</div> 
            <div class='ind'>Date of Birth: " . $dob . "</div> 
            <div class='ind'>Account Type: " . $account_type . "</div> 
        </div>"; 

        // Query to fetch transactions related to the account
        $getTransactionsQuery = mysqli_query($con, "SELECT * FROM transactions WHERE from_account_id='$account_id' OR to_account_id='$account_id'"); 

        if(mysqli_num_rows($getTransactionsQuery) == 0) { 
            echo "<div class='transactions'>No transactions available</div>"; 
        } else { 
            echo "<div class='transactions'><h4>Transactions</h4>"; 
            while($getTransactions = mysqli_fetch_array($getTransactionsQuery)) { 
                $transaction_id = $getTransactions['id']; 
                $from_account_id = $getTransactions['from_account_id']; 
                $to_account_id = $getTransactions['to_account_id']; 
                $amount = $getTransactions['amount']; 
                $transaction_date = $getTransactions['transaction_date']; 
                echo "<div class='transaction'> 
                    <div class='ind'>Transaction ID: " . $transaction_id . "</div> 
                    <div class='ind'>From Account ID: " . $from_account_id . "</div> 
                    <div class='ind'>To Account ID: " . $to_account_id . "</div> 
                    <div class='ind'>Amount: " . $amount . "</div> 
                    <div class='ind'>Date: " . $transaction_date . "</div> 
                </div>"; 
            } 
            echo "</div>"; 
        } 
    } 
} 
?> 
</body> 
</html>
