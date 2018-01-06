<?php require('init.php');
if (isset($_POST)) {
    $index = array_keys($_POST)[0];
    if (substr($index, 0, 8) == "download" || substr($index, 0, 4) == "edit" || substr($index, 0, 6) == "delete") {
        $file_id = filter_var($index, FILTER_SANITIZE_NUMBER_INT);
        $q = "SELECT file_name FROM files WHERE id = " . $file_id;
        $filename = mysqli_query($link, $q);
        $filename = mysqli_fetch_assoc($filename);
        $filename = $filename["file_name"];
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
    
        } else if (substr($index, 0, 4) == "edit") {
            $q = "UPDATE files SET file_name = '" . $_POST[$index] . "', file_path = 'users/" . $_SESSION['username'] . "/" . $_POST[$index] . "'" . " WHERE id = " . $file_id;
            mysqli_query($link, $q);
            rename('users/'.$_SESSION['username'].'/'.$filename, 'users/'.$_SESSION['username'].'/'. $_POST[$index]);
    
        } else if (substr($index, 0, 6) == "delete"){
            $q = "DELETE FROM files WHERE id = " . $file_id;
            mysqli_query($link, $q);
            unlink('users/'.$_SESSION['username'].'/'.$filename);
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

