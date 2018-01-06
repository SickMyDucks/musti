<?php
require('init.php');
$login_error = '';
$username = '';
$password = '';
if (!empty($_POST['username']) && !empty($_POST['password']))
{
    $username = htmlentities($_POST['username']);
    $password = $_POST['password'];
    
    $q = "SELECT * FROM users WHERE password = '". $password . "' AND username = '" . $username . "'";
    $result = mysqli_query($link, $q);
    $user = mysqli_fetch_assoc($result);
    if ($user === NULL)
    {
        $login_error = 'Invalid username or password';
    }
    else
    {
        session_start();
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
    
        header('Location: index.php');
        exit();
    }
}
$title = "Login";
ob_start();
?>
<form action="login.php" method="POST">
    <div class="errors"><?= $login_error ?></div>
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?= $username ?>"><br>
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <button type="submit">Login</button>
</form>
<?php
$content = ob_get_contents();
ob_end_clean();
require('layout.php');