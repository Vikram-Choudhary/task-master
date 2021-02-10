<?php
session_start();
require_once "connect.php";

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno . "<br>";
    echo "Description: " . $connection->connect_error;
} else {
    $email_id = $_POST['email'];
    $password = $_POST['password'];
    if (preg_match(
        "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",
        $email_id
    )) {
        $sql = "SELECT * FROM users WHERE BINARY email_id='$email_id' AND BINARY password='$password'";
        if ($result = $connection->query($sql)) {
            $usersCount = $result->num_rows;
            if ($usersCount > 0) {
                $_SESSION['logged-in'] = true;
                $row = $result->fetch_assoc();
                $result->free_result();
                $_SESSION['user'] = $row['name'];
                unset($_SESSION['loginError']);
                if ($row['isadmin']) {
                    $_SESSION['isadmin'] = $row['isadmin'];
                    header('Location: adminindex.php');
                } else {
                    $_SESSION['userId'] = $row['users_id'];
                    header('Location: userIndex.php');
                }
            } else {
                $_SESSION['loginError'] = '<span class="error-msg">Invalid inputs.</span>';
                header('Location: login.php');
            }
        }
    } else {
        $_SESSION['loginError'] = '<span class="error-msg">Invalid email id.</span>';
        header('Location: login.php');
    }
    $connection->close();
}
