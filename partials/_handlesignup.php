<?php
$showError = "false";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include '_dbconnect.php';
    $user_email = $_POST['signupemail'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupcPassword'];

    // check whether this email exists
    $existSql = "SELECT * FROM `users` WHERE user_email = 'user_email'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        $showError = "Email already in use";
    } else {
        if ($pass  == $cpass) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` ( `user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
                header("Location: /php-tutorial/34_forum/index.php?signupsuccess=true");
                exit();
            }
        } else {
            $showError = "Passwords Do not match";
        }
    }
    header("Location: /php-tutorial/34_forum/index.php?signupsuccess=false&error=$showError");
}