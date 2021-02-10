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
<?php

$per_page_record = 1;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}
unset($_SESSION['page']);
$_SESSION['page'] = $page;
$start_from = ($page - 1) * $per_page_record;
$userId = $_SESSION['userId'];
$query = "SELECT * FROM admin WHERE `users_id`= '$userId' LIMIT $start_from, $per_page_record";
$rs_result = $connection->query($query);
$tasksId = 0;
if ($row = mysqli_fetch_array($rs_result)) {
    $tasksId = $row['tasks_id'];
    $queryTask = "SELECT * FROM `tasks` WHERE `tasks_id` = '$tasksId'";
    $rs_result = $connection->query($queryTask);
    $rowTask = mysqli_fetch_array($rs_result);
}
?>
<?php
if (isset($_SESSION['userPageStatus'])) {
    echo $_SESSION['userPageStatus'];
    unset($_SESSION['userPageStatus']);
}
?>
<div class="container">
    <div style="text-align: center; padding: 8px">
        <h3>User Home</h3>
    </div>
    <div class="row head">
        <div class="col-sm-12 col-md-6">Logged in as <strong> <?php echo $_SESSION['user'] ?> </strong></div>
        <div class="col-sm-12 col-md-6 row d-flex flex-row-reverse">
            <?php include 'notification.php'; ?>
            <form action="logout.php" class="col-sm-12 col-md-4"><button type="sumbit" class="btn btn-dark m-1 col-sm-12">Logout</button></form>
        </div>
    </div>
    <div class="container row">
        <div class="col-md-8 col-sm-12">
            <table class="table table-striped table-hover table-responsive" style="height: 290px;">
                <tbody>
                    <?php
                    if ($tasksId) { ?>
                        <tr>
                            <th scope="row">Title:</th>
                            <td><?php echo $rowTask['title'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Details:</th>
                            <td><?php echo $rowTask['details'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Deadline:</th>
                            <td><?php echo $rowTask['deadline'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Completion:</th>
                            <td>
                                <?php
                                if ($rowTask['completion'])
                                    echo 'Completed';
                                else echo 'Pending'
                                ?></td>
                        </tr>
                    <?php
                    } else {
                    ?>
                        <tr>
                            <td>No task assigned.</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="row">
                <?php
                if ($tasksId) { ?>
                    <label class="col-sm-2 p-0"> Completed?</label>
                    <form method="post" action="changeStatus.php" style="display: inline-flex;">
                        <input style="display:none;" type="text" name="tasksId" value="<?php echo $tasksId ?>" />
                        <input class="mt-2" required type="checkbox" id="yes" name="completed" value="1" <?php if ($rowTask['completion']) echo 'disabled'; ?> <?php if ($rowTask['completion']) echo 'checked'; ?>>
                        <label class="pl-1 pr-1 mt-1" for="yes">Yes</label><br>
                        <button type="submit" class="btn btn-info ml-1" title="Assign task" <?php if ($rowTask['completion']) echo 'disabled'; ?>>Update</button>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <?php
            if ($tasksId) { ?>
                <label for="">
                    <?php
                    if ($rowTask['ext_request'] && !$rowTask['completion']) {
                        echo '<button type="button" class="btn btn-link" disabled><strong>Extension Requested:</br></strong>Your extension request has been sent, kindly wait for admin to respond.</button>';
                    } else if (!$rowTask['completion']) {
                        echo "<form method='post' action='extensionRequest.php'><input style='display:none;'' type='text' name='tasksId' value='$tasksId' /><button type='submit' class='btn btn-link' title='Request deadline extension'><strong>Request Extension</strong></button></form>";
                    }
                    ?>
                </label>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="pageMain">
        <div class="pagination">
            <?php
            $query = "SELECT COUNT(*) FROM admin WHERE  `users_id` = $userId";
            $rs_result = $connection->query($query);
            $row = mysqli_fetch_row($rs_result);
            $total_records = $row[0];

            $total_pages = ceil($total_records / $per_page_record);
            $pagLink = "";

            if ($page >= 2) {
                echo "<a href='userIndex.php?page=" . ($page - 1) . "'> Prev </a>";
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    $pagLink .= "<a class = 'active' href='userIndex.php?page=" . $i . "'>" . $i . " </a>";
                } else {
                    $pagLink .= "<a href='userIndex.php?page=" . $i . "'>" . $i . " </a>";
                }
            };
            echo $pagLink;

            if ($page < $total_pages) {
                echo "<a href='userIndex.php?page=" . ($page + 1) . "'>  Next </a>";
            }
            ?>
        </div>
    </div>
</div>

<?php $connection->close(); ?>
<?php include 'footer.php'; ?>