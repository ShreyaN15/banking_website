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
    <a href="index.php" style="color: white;">Home</a> 
    <div class="container"> 
        <h4>Add Bank Account</h4> 
        <form action="" method="POST"> 
            <input type="text" name="name" placeholder="Name" required><br> 
            <input type="date" name="dob" placeholder="Date of Birth" required><br> 
            <input type="text" name="acc_type" placeholder="Account Type" required><br> 
            <input type="number" step="0.01" name="initial_balance" placeholder="Initial Balance" required><br> 
            <input type="submit" name="submit" value="Create Account"> 
        </form>
    </div> 
</div> 
<?php 
if(isset($_POST['submit'])) { 
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']); 
    $acc_type = mysqli_real_escape_string($con, $_POST['acc_type']); 
    $initial_balance = mysqli_real_escape_string($con, $_POST['initial_balance']); 

    $insQuery = "INSERT INTO accounts (name, dob, account_type, balance) VALUES ('$name', '$dob', '$acc_type', '$initial_balance')"; 

    if(mysqli_query($con, $insQuery)) { 
        echo "<div class='status'>Account created successfully</div>"; 
    } else { 
        echo "<div class='status'>Error: " . mysqli_error($con) . "</div>";
    } 
} 
?> 
</body> 
</html>

