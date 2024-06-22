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
        <h4>Edit Bank Account Details</h4> 
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> 
            <input type="text" name="account_id" placeholder="Account ID" required><br> 
            <input type="text" name="name" placeholder="Name"><br> 
            <input type="date" name="dob" placeholder="Date of Birth"><br> 
            <input type="text" name="acc_type" placeholder="Account Type"><br> 
            <input type="number" name="balance" placeholder="Balance"><br> 
            <input type="submit" name="submit" value="Update"> 
        </form> 
    </div> 
</div> 
<?php 
if(isset($_POST['submit'])) { 
    $account_id = $_POST['account_id'];
    $name = $_POST['name']; 
    $dob = $_POST['dob']; 
    $acc_type = $_POST['acc_type']; 
    $balance = $_POST['balance']; 
    
    $updateFields = [];
    if ($name) $updateFields[] = "name='$name'";
    if ($dob) $updateFields[] = "dob='$dob'";
    if ($acc_type) $updateFields[] = "account_type='$acc_type'";
    if ($balance !== '') $updateFields[] = "balance='$balance'";
    
    if (!empty($updateFields)) {
        $updateQuery = "UPDATE accounts SET " . implode(', ', $updateFields) . " WHERE id='$account_id'";
        $updAccountQuery = mysqli_query($con, $updateQuery);

        if($updAccountQuery) { 
            echo "<div class='status'>Updated successfully</div>"; 
        } else { 
            echo "<div class='status'>Error updating record: " . mysqli_error($con) . "</div>"; 
        } 
    } else {
        echo "<div class='status'>No fields to update.</div>"; 
    }
} 
?> 
</body> 
</html>
