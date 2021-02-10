<?php
session_start();
require_once "connect.php";

$connection = new mysqli($host, $db_user, $db_password, $db_name);
//$shortName = $_GET['sn'];
if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno . "<br>";
    echo "Description: " . $connection->connect_error;
    exit();
} else {
    $taskTitle = trim($_POST['taskTitle']);
    $taskDescription = trim($_POST['taskDescription']);
    $taskAssignedUser = $_POST['searchuser'];
    $taskEndDate = $_POST['taskEndDate'];
    $taskComments = '(Admin): '.$_POST['taskComments'];
    $sqlCount = "SELECT * FROM `tasks` WHERE `title` = '$taskTitle'";
    $sqlUser = "SELECT * FROM `users` WHERE `email_id` = '$taskAssignedUser'";
    if (!mysqli_num_rows($connection->query($sqlCount))) {
        $sqlTask = "INSERT INTO `tasks`(`tasks_id`, `title`, `details`, `deadline`) VALUES (NULL,'$taskTitle','$taskDescription','$taskEndDate')";
        try {
            $userdata = $connection->query($sqlUser);
            while ($row = $userdata->fetch_assoc()) {
                $userId = $row['users_id'];
                $userName = $row['name'];
            }
            if (!$userId) throw new Exception("User not found!");
            $connection->query($sqlTask);
            $last_id = $connection->insert_id;
            $sqlAdmin = "INSERT INTO `admin`(`id`, `tasks_id`, `users_id`,`comments`) VALUES (NULL,'$last_id','$userId','$taskComments')";
            $connection->query($sqlAdmin);
            $_SESSION['addTaskError'] = "<script>alert('Task $taskTitle assigned to user $userName.')</script>";
            header('Location: assignTask.php');
        } catch (Exception $e) {
            $connection->rollback();
            $message = strval($e->getMessage());
            $_SESSION['addTaskError'] = "<script>alert('Failed to assign task! Try again. Error: $message')</script>";
            header('Location: assignTask.php');
        }
    } else {
        $_SESSION['addTaskError'] = '<script>alert("Error! Duplicate task entry")</script>';
        header('Location: assignTask.php');
    }
    $connection->close();
}
