<?php
    require('init.php');
    $target_dir = "users/".$_SESSION['username']."/";
    if (isset($_FILES["upload"]["name"])) {
        $file_name = basename($_FILES["upload"]["name"]);
        $is_file_set = true;
    } else {
        $file_name = "";
        $is_file_set = false;
    }
    $target_file = $target_dir . $file_name;

    if (file_exists($target_file) && substr($target_file, -1) != "/") {
        echo "<br>Sorry, file already exists.";
        $uploadOk = 0;
    } 
    if ($is_file_set == true) {
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $q = "INSERT INTO `files` (`id`, `file_name`, `file_path`, `owned_by_user_id`, `modified_last`) VALUES (NULL, '".$file_name."', '".$target_file."', '".$_SESSION['id']."', '".date('Y-m-d H:i:s')."')";
        mysqli_query($link, $q);
        header( 'refresh: 2; url=/index.php' );
        echo "<br>Redirection in 2 seconds.";
        } else {
            echo "<br>Sorry, there was an error uploading your file.";
        }
    }
    
?>