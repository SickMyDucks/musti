<?php
require('init.php');
$username_error = '';
$email_error = '';
$password_error = '';

if (!empty($_POST['sent']))
{
    if (strlen($_POST['username']) < 4)
        $username_error = "Username too short";
    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $email_error = "Invalid email !";
    elseif (strlen($_POST['password']) < 8)
        $password_error = 'Password too short';
    elseif ($_POST['password'] != $_POST['password_verification'])
        $password_error = "Passwords do not match";
}
$username = isset($_POST['username']) ? $_POST['username'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : "";
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : "";

if (!empty($_POST['firstname']) && !empty($_POST['lastname'])
    && !empty($_POST['username']) && !empty($_POST['email'])
    && !empty($_POST['password']) && !empty($_POST['password_verification']))
{
    $firstname = htmlentities($_POST['firstname']);
    $lastname = htmlentities($_POST['lastname']);
    $username = htmlentities($_POST['username']);
    $email = htmlentities($_POST['email']);
    $password = $_POST['password'];
    $password_verification = $_POST['password_verification'];
    
    if ($password === $password_verification)
    {
        $creation = date('Y-m-d H:i:s');
        
        $q = "INSERT INTO `users` (`id`, `creation`, `firstname`, `lastname`, `username`, `email`, `password`) VALUES (NULL, '".$creation."', '".$firstname."', '".$lastname."', '".$username."', '".$email."', '".$password."')";
        mysqli_query($link, $q);
        mkdir('users/'.$username);
        
        header('Location: index.php');
        exit();
    }
}
$title = "Register";
ob_start();
?>
<pre><?php var_dump($_POST);
var_dump($password_error);?></pre>
<form action="register.php" method="POST">
    <label>First Name</label>
    <input type="text" name="firstname" value="<?php echo $firstname; ?>"><br>
    <label>Last name</label>
    <input type="text" name="lastname" value="<?php echo $lastname; ?>"><br>
    <label>Username</label>
    <input type="text" name="username" value="<?php echo $username; ?>"><?= $username_error ?><br>
    <label>Email</label>
    <input type="email" name="email" value="<?php echo $email; ?>"><?=$email_error ?><br>
    <label>Password</label>
    <input type="password" name="password"><?= $password_error?><br>
    <label>Repeat password</label>
    <input type="password" name="password_verification"><br>
    <input type="hidden" name="sent" value="1">
    <input type="submit">
</form>
<?php
$content = ob_get_contents();
ob_end_clean();
require('layout.php');