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
        <h4>Delete Bank Account</h4> 
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> 
            <input type="text" name="account_id" placeholder="Account ID" required><br> 
            <input type="submit" name="submit" value="Delete"> 
        </form> 
    </div> 
</div> 
<?php 
if(isset($_POST['submit'])) { 
    $account_id = $_POST['account_id']; 
    
    // Check if account exists
    $checkAccountQuery = mysqli_query($con, "SELECT * FROM accounts WHERE id='$account_id'");
    if(mysqli_num_rows($checkAccountQuery) > 0) {
        // Delete transactions related to the account
        $delTransactionsQuery = mysqli_query($con, "DELETE FROM transactions WHERE from_account_id='$account_id' OR to_account_id='$account_id'");
        
        // Delete the account
        $delAccountQuery = mysqli_query($con, "DELETE FROM accounts WHERE id='$account_id'");
        
        if($delAccountQuery) { 
            echo "<div class='status'>Account deleted successfully</div>"; 
        } else { 
            echo "<div class='status'>Error deleting account: " . mysqli_error($con) . "</div>"; 
        } 
    } else {
        echo "<div class='status'>Account not found. Please check the Account ID</div>"; 
    }
} 
?> 
</body> 
</html>
