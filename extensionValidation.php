<?php
session_start();
require_once "connect.php";

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno . "<br>";
    echo "Description: " . $connection->connect_error;
} else {
    $extension = $_POST['extension'];
    $tasksId = $_POST['tasksId'];
    $taskExtDate = array_key_exists('taskExtDate', $_POST) ? $_POST['taskExtDate'] : null;
    if ($extension) {
        $sql = "UPDATE tasks SET ext_request = 0 , ext_approval = 1 , deadline = '$taskExtDate' WHERE tasks_id = $tasksId";
    } else {
        $sql = "UPDATE tasks SET ext_request = 0 , ext_approval = 2 WHERE tasks_id = $tasksId";
    }
    try {
        $result = $connection->query($sql);
        $_SESSION['updateProgress'] = "<script>alert('Task updated!')</script>";
        header('Location: viewProgress.php?page=' . $_SESSION['page']);
    } catch (Exception $e) {
        $connection->rollback();
        $message = strval($e->getMessage());
        $_SESSION['updateProgress'] = "<script>alert('Failed to update! Try again. Error: $message')</script>";
        header('Location: viewProgress.php?page=' . $_SESSION['page']);
    }
    $connection->close();
}
