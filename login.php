<?php
/*******************************************************************************
* Invoice Management System
*
* Version: 1.0	                                                               *
* Developer:  Abhishek Raj                                				       *
*******************************************************************************/

include_once 'header.php';

// Connect to the database
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// Output any connection error
if ($mysqli->connect_error) {
    die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

session_start();
if ($_POST['username'] != "" && $_POST['password'] != "") {
    extract($_POST);

    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $pass_encrypt = mysqli_real_escape_string($mysqli, $_POST['password']);

    // Prepare the query to prevent SQL injection
    $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `username` = ?");
    $stmt->bind_param("s", $username);  // Bind the parameter to the prepared statement

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user is found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verify password using password_verify (assuming stored password is hashed)
        if (password_verify($pass_encrypt, $row['password'])) {
            $_SESSION['login_username'] = $row['username'];
            echo 1;  // Successful login
        } else {
            echo 0;  // Incorrect password
        }
    } else {
        echo 0;  // No user found
    }

    // Close the statement
    $stmt->close();

} else {

    header("Location:index.php");

}
?>

<?php include_once 'footer.php'; ?>
