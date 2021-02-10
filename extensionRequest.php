<?php
session_start();
require_once "connect.php";

$connection = new mysqli($host, $db_user, $db_password, $db_name);
if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno . "<br>";
    echo "Description: " . $connection->connect_error;
    exit();
} else {
    $tasksId = $_POST['tasksId'];
    try {
        $sql = "UPDATE tasks SET ext_request = 1 WHERE tasks_id = $tasksId";
        $result = $connection->query($sql);
        header('Location: userIndex.php?page='.$_SESSION['page']);
    } catch (Exception $e) {
        $connection->rollback();
        $message = strval($e->getMessage());
        $_SESSION['userPageStatus'] = "<script>alert('Failed to request! Try again. Error: $message')</script>";
        header('Location: userIndex.php?page='.$_SESSION['page']);
    }
    $connection->close();
}
