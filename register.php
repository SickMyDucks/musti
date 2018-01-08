<?php
require('init.php');
$username_error = '';
$email_error = '';
$password_error = '';

if (!empty($_POST['sent']))
{   
    $q = "SELECT username FROM users WHERE username = ?";
    $stmt = mysqli_prepare($link, $q);
    mysqli_stmt_bind_param($stmt, 's', $_POST['username']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $usernameField);
    
    while (mysqli_stmt_fetch($stmt))
    {   
        $usernameExisting = $usernameField;
    }
    mysqli_stmt_close($stmt);

    $isFormValid = true;
    if (strlen($_POST['username']) < 4) {
        $username_error = "Username too short";
        $isFormValid = false;
    } elseif (!empty($usernameExisting)) {
        $username_error = 'Username already taken, choose another one.';
        $isFormValid = false;
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email !";
        $isFormValid = false;
    } elseif (strlen($_POST['password']) < 8) {
        $password_error = 'Password too short';
        $isFormValid = false;
    } elseif ($_POST['password'] != $_POST['password_verification']) {
        $password_error = "Passwords do not match";
        $isFormValid = false;
    }
        
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
    
    if ($password === $password_verification && $isFormValid)
    {
        $creation = date('Y-m-d H:i:s');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $q = "INSERT INTO `users` (`id`, `creation`, `firstname`, `lastname`, `username`, `email`, `password`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'ssssss', $creation, $firstname, $lastname, $username, $email, $hashed_password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($link);
        
        mkdir('users/'.$username);
        
        header('Location: index.php');
        exit();
    }
}
ob_start();
?>
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