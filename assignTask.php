<?php
session_start();
if (!(isset($_SESSION['logged-in']))) {
    header('Location: login.php');
    exit();
}

require_once "connect.php";

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno . "<br>";
    echo "Description: " . $connection->connect_error;
    exit();
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <div style="text-align: center; padding: 8px">
        <h3>Assign Task</h3>
    </div>
    <div class="row head">
        <div class="col-sm-12 col-md-6">Logged in as <strong> <?php echo $_SESSION['user'] ?> </strong></div>
        <div class="col-sm-12 col-md-6 row d-flex flex-row-reverse">
            <?php include 'notification.php'; ?>
            <form action="logout.php" class="col-sm-12 col-md-4"><button type="sumbit" class="btn btn-dark m-1 col-sm-12">Logout</button></form>
            <form action="adminIndex.php" class="col-sm-12 col-md-4 "><button type="sumbit" class="btn btn-dark m-1 col-sm-12">Home</button></form>
        </div>
    </div>
    <div class="container">
        <form method="post" action="assignTaskValidation.php">
            <div class="d-flex row bd-highlight">
                <div class="p-2 flex-fill col-sm-12 row">
                    <div class="col-md-8 col-sm-12">
                        <label class="col-md-5 col-sm-12 p-0" for="searchuser">Search user by email id:</label>
                        <input required autofocus class="col-md-6 col-sm-12" list="userlist" placeholder="Search user" name="searchuser" id="searchuser">
                        <datalist id="userlist">
                            <?php

                            $sql = "SELECT * FROM `users` WHERE `isadmin` = 0 ORDER BY `isadmin` ASC";

                            if ($result = $connection->query($sql)) {
                                $userlist = $result->num_rows;
                                if ($userlist > 0) {

                                    while ($row = mysqli_fetch_array($result)) {
                                        $sn = $row['email_id'];
                                        echo "
                            <option value='$sn'>";
                                    }
                                    $result->free_result();
                                } else {
                                    echo "No users found";
                                }
                            }

                            ?>
                        </datalist>
                        <input required type="text" title="Task title" placeholder="Enter task title" class="col-sm-12" name="taskTitle">
                        <textarea required rows="6" title="Task details" placeholder="Enter task details..." class="col-sm-12" name="taskDescription"></textarea>
                        <label class="col-sm-12 p-0 pt-1" for="searchuser">Deadline Date:</label>
                        <input required type="date" class="col-sm-12 m-0" name="taskEndDate" title="Select task deadline date" min=<?php date_default_timezone_set('Asia/Kolkata'); echo date('Y-m-d') ?> onkeydown="return false">
                    </div>
                    <!-- <div class="col-md-4 col-sm-12">
                    //commnets box
                    </div> -->
                </div>

                <div class="col-md-12 col-sm-12 text-right">
                    <button type="reset" class="btn btn-danger" title="Clear form">Clear</button>
                    <button type="submit" class="btn btn-info" title="Assign task">Assign</button>
                </div>
            </div>
        </form>
        <?php
        if (isset($_SESSION['addTaskError'])) {
            echo $_SESSION['addTaskError'];
            unset($_SESSION['addTaskError']);
        }
        ?>
    </div>
</div>

<?php $connection->close(); ?>
<?php include 'footer.php'; ?>