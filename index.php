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
    $date = date('Y-m-d H:i:s');
    $q = "INSERT INTO `files` (`id`, `file_name`, `file_path`, `owned_by_user_id`, `modified_last`) VALUES (NULL, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $q);
    mysqli_stmt_bind_param($stmt, 'ssis', $file_name, $target_file, $_SESSION['id'], $date);
    mysqli_stmt_execute($stmt);
    
    } else {
        $logs = "Sorry, there was an error uploading your file.";
    }
}
/* END OF UPLOAD*/ 

/* Actions : Download, Edit, Delete */
if (isset($_POST)) {
    $index = array_keys($_POST)[0];
    if (substr($index, 0, 8) == "download" || substr($index, 0, 4) == "edit" || substr($index, 0, 6) == "delete") { //Checks the value of the button
        $file_id = filter_var($index, FILTER_SANITIZE_NUMBER_INT); //Fetches the number at the end of the value
        $q = "SELECT file_name FROM files WHERE id = ?"; //$file_id;
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'i', $file_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $fileName);
        while (mysqli_stmt_fetch($stmt)) {
            $filename = $fileName;
        }

        /* Download */
        if(substr($index, 0, 8) == "download") {
            $file = 'users/'.$_SESSION['username'].'/'.$filename;
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        /* End Download */

        /* Edit */
        } else if (substr($index, 0, 4) == "edit") {
            $path_of_the_file = "users/" . $_SESSION['username'] . "/" . $_POST[$index];
            $creation = date('Y-m-d H:i:s');
            $q = "UPDATE files SET file_name = ?, file_path = ?, modified_last = ? WHERE id = ?";
            $stmt = mysqli_prepare($link, $q);
            mysqli_stmt_bind_param($stmt, 'sssi', $_POST[$index], $path_of_the_file, $creation, $file_id);
            mysqli_stmt_execute($stmt);

            rename('users/'.$_SESSION['username'].'/'.$filename, 'users/'.$_SESSION['username'].'/'. $_POST[$index]);
            $logs = 'File Edited';
        /* End Edit */

        /* Delete */
        } else if (substr($index, 0, 6) == "delete"){
            $q = "DELETE FROM files WHERE id = ?";
            $stmt = mysqli_prepare($link, $q);
            mysqli_stmt_bind_param($stmt, 'i', $file_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            unlink('users/'.$_SESSION['username'].'/'.$filename);
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
