<?php
require('init.php');
$index = array_keys($_POST)[0];
if (isset($_POST)) {
    $file_id = filter_var($index, FILTER_SANITIZE_NUMBER_INT);
    if(substr($index, 0, 8) == "download") {

    } else if (substr($index, 0, 4) == "edit") {
        $q = "SELECT file_name FROM files WHERE id = " . $file_id;
        $filename = mysqli_query($link, $q);
        $filename = mysqli_fetch_assoc($filename);
        var_dump($filename);
        echo '<br>'. 'users/'.$_SESSION['username'].'/'.$filename["file_name"];
        $q = "UPDATE files SET file_name = 'edited', file_path = 'users/" . $_SESSION['username'] . "/" . "editedfile'" . " WHERE id = " . $file_id;
        mysqli_query($link, $q);
        rename('users/'.$_SESSION['username'].'/'.$filename["file_name"], 'users/'.$_SESSION['username'].'/'. 'editedfile');
    } else {
        echo 'hi there';
    }
}
    