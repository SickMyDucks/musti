<?php 
    $q = "SELECT file_name, modified_last FROM files WHERE owned_by_user_id = '". $_SESSION['id'] . "'";
    $result = mysqli_query($link, $q);
    $data = [];
    while ($row = mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
?>
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <label for="upload">Upload a a file : </label><input type="file" name="upload" id="upload" required><br>
    <input type="submit" value="Send";>
</form>

<table border="0">
<?php if (count($data) == 0):?>
    <tr><td>No file existing.</td></tr>

<?php 
    endif;
    foreach ($data as $article):
?>
    <tr>
        <td><i class="fa fa-file" aria-hidden="true"></i></td>
        <td><?= $article["file_name"]?></td>
        <td><?= $article["modified_last"]?></td>
        <td><a href="http://musti.keepthis4.me/users/<?= $_SESSION['username'].'/'.$article["file_name"]?>" download="<?=$article["file_name"]?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>
        <td><i class="fa fa-pencil" aria-hidden="true"></i></td>
        <td><i class="fa fa-trash" aria-hidden="true"></i></td>
    </tr>
<?php endforeach;?>
</table>