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
    $completed = $_POST['completed'];
    try {
        if ($completed)
            $sql = "UPDATE tasks SET completion = $completed, ext_request = 0, ext_approval = 0 WHERE tasks_id = $tasksId";
        else
            $sql = "UPDATE tasks SET completion = $completed, ext_approval = 3  WHERE tasks_id = $tasksId";
        $result = $connection->query($sql);
        if ($_SESSION['isadmin'])
            header('Location: viewProgress.php?page=' . $_SESSION['page']);
        else
            header('Location: userIndex.php?page=' . $_SESSION['page']);
    } catch (Exception $e) {
        $connection->rollback();
        $message = strval($e->getMessage());
        $_SESSION['userPageStatus'] = "<script>alert('Failed to update! Try again. Error: $message')</script>";
        if ($_SESSION['isadmin'])
            header('Location: viewProgress.php?page=' . $_SESSION['page']);
        else
            header('Location: userIndex.php?page=' . $_SESSION['page']);
    }
    $connection->close();
}
