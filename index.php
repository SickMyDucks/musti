<?php require('init.php');
/* UPLOAD*/
$target_dir = "users/".$_SESSION['username']."/";
if (isset($_FILES["upload"]["name"])) {
    $file_name = basename($_FILES["upload"]["name"]);
    $is_file_set = true;
} else {
    $file_name = "";
    $is_file_set = false;
}
$target_file = $target_dir . $file_name;


$uploadOk = 1;
if (file_exists($target_file) && substr($target_file, -1) != "/") {
    $logs = "Sorry, file already exists.";
    $uploadOk = 0;
} 


if ($is_file_set == true && $uploadOk === 1) {
    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
    $logs = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    
    } else {
        $logs = "Sorry, there was an error uploading your file.";
    }
}
/* END OF UPLOAD*/ 

/* Actions : Download, Edit, Delete */
if (isset($_POST)) {
    $key = array_keys($_POST)[0];
    if (substr($key, 0, 8) == "download" || substr($key, 0, 4) == "edit" || substr($key, 0, 6) == "delete") { //Checks the value of the button
        $file_key = filter_var($key, FILTER_SANITIZE_NUMBER_INT); //Fetches the number at the end of the value
        $currentFolder = array_diff(scandir("users/".$_SESSION['username']), array('..', '.'));

        /* Download */
        if(substr($key, 0, 8) == "download") {
            $file = 'users/'.$_SESSION['username'].'/'.$currentFolder[$file_key];
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        /* End Download */

        /* Edit */
        } else if (substr($key, 0, 4) == "edit") {
            $new_file_path = "users/" . $_SESSION['username'] . "/" . $_POST[$key];
            rename('users/'.$_SESSION['username'].'/'.$currentFolder[$file_key], $new_file_path);
            $logs = 'File Edited';
        /* End Edit */

        /* Delete */
        } else if (substr($key, 0, 6) == "delete"){
            unlink('users/'.$_SESSION['username'].'/'.$currentFolder[$file_key]);
            $logs = 'File deleted.';
            /* End Delete */
        }
    }
}


ob_start();
if (!isset($_SESSION['username'])): ?>
<h3>Login to upload files.</h3>
<?php else: ?>
<?php include('files.php')?>
<?php endif;
$content = ob_get_contents();
ob_end_clean();
require('layout.php');
