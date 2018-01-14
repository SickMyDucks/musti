<?php
require('init.php');
$login_error = '';
$username = '';
$password = '';

if (isset($_SESSION['username'])) {
    session_destroy();
}
if (!empty($_POST['username']) && !empty($_POST['password']))
{
    $username = htmlentities($_POST['username']);
    $password = $_POST['password'];
    
    $q = "SELECT `id`, `username`, `password` FROM users WHERE username = ?";
    $stmt = mysqli_prepare($link, $q);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id, $user_name, $hashed);
    while (mysqli_stmt_fetch($stmt)) {
        $user = [];
        $user['id'] = $user_id;
        $user['username'] = $user_name;
        $user['password'] = $hashed;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);

    if (password_verify($_POST['password'], $user['password']) === true) {
        session_start();
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit();
    } else {
        $login_error = 'Invalid username or password';
    }
}
ob_start();
?>
<form action="login.php" method="POST">
    <div class="logs"><?= $login_error ?></div>
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?= $username ?>"><br>
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <button type="submit">Login</button>
</form>
<a href="lostpassword.php" class="password_reset">I lost my password</a>
<?php
$content = ob_get_contents();
ob_end_clean();
require('layout.php');