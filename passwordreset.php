<?php
require('init.php');
if (isset($_SESSION['username'])) {
    session_destroy();
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $q = "SELECT `id`, `temp_password` FROM users WHERE email = ?";
    $stmt = mysqli_prepare($link, $q);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $password);
    while (mysqli_stmt_fetch($stmt)) {
        $user['id'] = $id;
        $user['password'] = $password;
    }
    mysqli_stmt_close($stmt);

    $isFormValid = true;
    if (strlen($_POST['password']) < 8) {
        $logs = 'Password too short';
        $isFormValid = false;
    } elseif ($_POST['password'] != $_POST['password_repeat']) {
        $logs = "Passwords do not match";
        $isFormValid = false;
    }
    if ($isFormValid == false) {
        $email = $_POST['email'];
    }elseif (password_verify($_POST['code_sent'], $password) && $isFormValid) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $q = "UPDATE `users` SET `password` = ?  WHERE `users`.`id` = ?";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'ss', $hashed_password, $user['id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $q = "UPDATE `users` SET `temp_password` = '' WHERE `users`.`id` =  ?";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 's', $user['id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $logs = "Password changed successfully";
        header("refresh: 2; ./login.php");
    } else {
        $logs = "Code incorrect.";
    }
}

ob_start();
?>
<form action="passwordreset.php" method="post">
    <div class="logs"><?= $logs ?></div>
    <label for="email">Email : </label><input type="email" name="email" id="email" value="<?php if (isset($email)){echo $email;}?>"><br>
    <label for="code_sent">Code sent by email : </label>
    <input type="text" name="code_sent" id="code_sent"><br>
    <label for="password">Enter new password : </label>
    <input type="password" name="password" id="password"><br>
    <label for="password_repeat">Confirm new password : </label>
    <input type="password" name="password_repeat" id="password_repeat"><br>
    <button type="submit">Reset password</button>

</form>
<?php
$content = ob_get_contents();
ob_end_clean();
require('layout.php');