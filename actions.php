<?php
require('init.php');
$index = array_keys($_POST)[0];
var_dump($_POST);
var_dump($index);
if (isset($_POST)) {
    $file_id = filter_var($index, FILTER_SANITIZE_NUMBER_INT);
    if(substr($index, 0, 8) == "download") {
        
    } else if (substr($index, 0, 4) == "edit") {
        $q = "SELECT file_name FROM files WHERE id = " . $file_id;
        $filename = mysqli_query($link, $q);
        $filename = mysqli_fetch_assoc($filename);
        $q = "UPDATE files SET file_name = '" . $_POST[$index] . "', file_path = 'users/" . $_SESSION['username'] . "/" . $_POST[$index] . "'" . " WHERE id = " . $file_id;
        mysqli_query($link, $q);
        rename('users/'.$_SESSION['username'].'/'.$filename["file_name"], 'users/'.$_SESSION['username'].'/'. $_POST[$index]);
    } else {
        $q = "SELECT file_name FROM files WHERE id = " . $file_id;
        $filename = mysqli_query($link, $q);
        $filename = mysqli_fetch_assoc($filename);
        $q = "DELETE FROM files WHERE id = " . $file_id;
        mysqli_query($link, $q);
        unlink('users/'.$_SESSION['username'].'/'.$filename["file_name"]);
    }
}
    