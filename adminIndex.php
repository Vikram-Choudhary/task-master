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
        <h3>Admin Home</h3>
    </div>
    <div class="row head">
        <div class="col-sm-12 col-md-6">Logged in as <strong> <?php echo $_SESSION['user'] ?> </strong></div>
        <div class="col-sm-12 col-md-6 row d-flex flex-row-reverse">
            <?php include 'notification.php'; ?>
            <form action="logout.php" class="col-sm-12 col-md-4"><button type="sumbit" class="btn btn-dark m-1 col-sm-12">Logout</button></form>
        </div>
    </div>
    <div class="row lg-12 p-2 m-1 d-flex justify-content-center">
        <div class="col-md-4 col-sm-12 p-1">
            <form action="assignTask.php">
                <button type="sumbit" class="btn btn-primary btn-lg btn-block">Assign Task</button>
            </form>
        </div>
        <div class="col-md-4 col-sm-12 p-1">
            <form action="viewProgress.php">
                <button type="sumbit" class="btn btn-secondary btn-lg btn-block">View Progress</button>
            </form>
        </div>
        <?php
        if (isset($_SESSION['addTaskError'])) {
            echo $_SESSION['addTaskError'];
            unset($_SESSION['addTaskError']);
        }
        ?>
    </div>
    <div class="col-md-4 col-sm-12 p-1">
        <button type="button" class="btn btn-link">Extension requests:
            <?php
            $sqlExt = "SELECT COUNT(*) FROM tasks WHERE ext_request = 1";
            $result = $connection->query($sqlExt);
            $row = mysqli_fetch_array($result);
            $_SESSION['extensionReq'] =  $row[0];
            if ($row[0])
                echo  $row[0];
            else echo 0
            ?></button>
    </div>
</div>

<?php $connection->close(); ?>
<?php include 'footer.php'; ?>