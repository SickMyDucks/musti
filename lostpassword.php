<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require('init.php');
if (isset($_SESSION['username'])) {
    session_destroy();
}

if (isset($_POST['email'])){
    $email = $_POST['email'];
}

$q = 'SELECT `id` FROM users WHERE `email` = ?';
$stmt = mysqli_prepare($link, $q);
mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id);
while (mysqli_stmt_fetch($stmt)) {
    $user = $id;
}
mysqli_stmt_close($stmt);

if (!empty($user)) {
    $code = rand(10000000, 99999999);
    $temp_password = password_hash($code, PASSWORD_DEFAULT);
    $q = "UPDATE `users` SET `temp_password` = ?  WHERE `users`.`id` = ?";
    $stmt = mysqli_prepare($link, $q);
    mysqli_stmt_bind_param($stmt, 'si', $temp_password, $user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    //Load composer's autoloader
    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'node-email-1.pulsepanel.eu';           // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'musti@neilrichter.com';            // SMTP username
        $mail->Password = "filermail";                        // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('musti@neilrichter.com', 'Filer');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Password reinitialisation';
        $mail->Body    = 'Enter the following code at <a href="http://musti.keepthis4.me/passwordreset.php">this address</a> to reset your password<br>'.$code;
        $mail->AltBody = 'Enter the following code at http://musti.keepthis4.me/passwordreset.php to reset your password\n'.$code;

        $mail->send();
        $logs = 'Mail has been sent';
        header("Location: ./passwordreset.php");
    } catch (Exception $e) {
        $logs = 'Mail could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}

ob_start();
?>
<form action="lostpassword.php" method="post">
    <label for="email">Email : </label><input type="email" name="email" id="email">
    <button type="submit">Send me a code</button>
</form>
<?php
$content = ob_get_contents();
ob_clean();
require('layout.php');