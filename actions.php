<?php
require('init.php');
$index = array_keys($_POST)[0];
var_dump($_POST);
var_dump($index);
if (isset($_POST)) {
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

    } else {
        $q = "DELETE FROM files WHERE id = " . $file_id;
        mysqli_query($link, $q);
        unlink('users/'.$_SESSION['username'].'/'.$filename);
    }
}
    