<?php
$isAdmin = array_key_exists('isadmin', $_SESSION) ? $_SESSION['isadmin'] : 0;
if ($isAdmin) {
    $sql = "SELECT * FROM `tasks` ORDER BY `tasks`.`updates` DESC";
} else {
    $userId = $_SESSION['userId'];
    $query = "SELECT * FROM admin WHERE `users_id`= '$userId'";
    $rs_result = $connection->query($query);
    $tasks_id = array();
    while ($row = mysqli_fetch_array($rs_result)) {
        array_push($tasks_id, $row['tasks_id']);
    }
    $sql = "SELECT * FROM `tasks` WHERE tasks_id in ('" . implode("','", $tasks_id) . "') ORDER BY `tasks`.`updates` DESC";
}
?>
<div class="btn-group ">
    <button type="button" class="btn btn-dark m-1 col-sm-12 dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
        </svg> <sup style="color:#FFFF00;">&#9864;</sup>
    </button>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-sm-left" style="width: 200px !important; max-height: 400px !important; overflow: auto;">
        <?php
        if ($result = $connection->query($sql)) {
            $list = $result->num_rows;
            if ($list > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $message1 = '';
                    $message2 = '';
                    $message3 = '';
                    $color = 'info';
                    date_default_timezone_set('Asia/Kolkata');
                    if (!$row['completion'] && date($row['deadline']) === date("Y-m-d", time())) {
                        $message1 = '<span style="color:red;">&#9864;</span>
                        Task deadline alert<span style="color:red;">&#33;</span></br><span style="color:#007bff; padding-left: 20px;">Date: ' . $row['deadline'] . '</span></br>';
                        $color = 'danger';
                    }
                    if ($row['ext_request']) {
                        $message2 = '<span style="color:green;">&#9864;</span>
                        Task deadline extension requested.</br>';
                        $color = 'warning';
                    } else if ($row['completion']) {
                        $message2 = '<span style="color:green;">&#9864;</span>
                        Task completed.</br>';
                        $color = 'success';
                    } else if ($row['ext_approval'] == 1) {
                        $message2 = '<span style="color:green;">&#9864;</span>
                        Task deadline  extension approved.</br><span style="color:#007bff; padding-left: 20px;">New date:' . $row['deadline'] . '</span></br>';
                        $color = 'success';
                    } else if ($row['ext_approval'] == 2) {
                        $message2 = '<span style="color:red;">&#9864;</span>
                        Task deadline  extension rejected<span style="color:red;">&#33;</span></br>';
                        $color = 'danger';
                    } else if ($row['ext_approval'] == 3) {
                        $message2 = '<span style="color:#FFFF00;">&#9864;</span>
                        Task re-assigned<span style="color:red;">&#33;</span></br>';
                        $color = 'warning';
                    } else {
                        $message2 = '<span style="color:#007bff;">&#9864;</span>
                        New task assigned.<span style="color:silver;">&#9733;</span></br>';
                        $color = 'info';
                    }
        ?>
                    <div class='card border-<?php echo $color ?> mt-1' style="border-width: 2px;">
                        <strong style="color:black">Task: <?php echo $row['title'] ?></strong>
                        <div class="card-body p-1">
                            <?php echo $message2;
                            echo  $message1; ?>
                        </div>
                    </div>
        <?php }
                $result->free_result();
            } else {
                echo '<span class="dropdown-item">No notification</span>';
            }
        }
        ?>
    </div>

</div>