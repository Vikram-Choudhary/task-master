<?php
session_start();
if (isset($_SESSION['logged-in'])) {
    header('Location: index.php');
    exit();
}
?>
<?php include 'header.php'; ?>
<div style="text-align: center; padding: 8px"><h1>Taskmaster</h1>
</div>
<form class="loginform" method="post" action="loginValidation.php">
    <div class="container">
        <label for="uname"><b>Email ID:</b></label>
        <input autofocus className="inputBox" type="email" placeholder="Enter email id" name="email" required>

        <label for="psw"><b>Password:</b></label>
        <input className="inputBox" type="password" placeholder="Enter your password" name="password" required>

        <button type="submit" class="btn btn-success loginbutton">Login</button>
    </div>
    <div style="color:red; text-align: center; padding: 8px">
        <?php
        if (isset($_SESSION['loginError'])) {
            echo $_SESSION['loginError'];
        }
        ?>
    </div>
</form>
<?php include 'footer.php'; ?>