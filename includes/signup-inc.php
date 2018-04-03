<?php

if (isset($_POST['submit'])) {
    include_once 'dbh-inc.php';

    $first = mysqli_real_escape_string($conn, $_POST['first']);
    $last = mysqli_real_escape_string($conn, $_POST['last']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    // Error handlers
    // Check for empty fields



    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?signup=email");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $result_check = mysqli_num_rows($result);
        if ($result_check > 0) {
            header("Location: ../signup.php?signup=usertaken");
            exit();
        } else {
            $hasedPWd = password_hash($pass, PASSWORD_DEFAULT);
            // insert the user into the DB
            $sql = "INSERT INTO users (first, last, email, pass) VALUES ('$first', '$last', '$email', '$hasedPWd');";
            mysqli_query($conn, $sql);
            header("Location: ../signup.php?signup=success");
            exit();
        }
    }



} else {
    header("Location: ../signup.php");
    exit();
}
