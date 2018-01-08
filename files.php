<?php 
    $q = "SELECT id, file_name, modified_last FROM files WHERE owned_by_user_id = ?";
    $stmt = mysqli_prepare($link, $q);
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);
    
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $fileID, $fileName, $modifiedLast);
    
    $data = [];
    while (mysqli_stmt_fetch($stmt))
    {
        $row = [];
        $row['id'] = $fileID;
        $row['file_name'] = $fileName;
        $row['modified_last'] = $modifiedLast;
        $data[] = $row;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
?>
<form action="index.php" method="POST" enctype="multipart/form-data">
    <label for="upload">Upload a a file : </label><input type="file" name="upload" id="upload" required><br>
    <input type="submit" value="Send">
    <div class="logs"><?= $logs?></div>
</form>
<form action="index.php" method="POST" id="files">
    <table>
    <?php if (count($data) == 0):?>
        <tr><td>No file existing.</td></tr>
    <?php else:?>
        
            <tr>
                <td></td>
                <td>File Name</td>
                <td>Modified Last</td>
                <td>Download</td>
                <td>Edit</td>
                <td>Delete</td>
            </tr>
    <?php endif;?>
        <?php foreach ($data as $item):?>
            <tr>
                <td><i class="fa fa-file" aria-hidden="true"></i></td>
                <td><span><?= $item["file_name"]?></span></td>
                <td><?= $item["modified_last"]?></td>
                <td><button type="submit" name="download<?= $item["id"]?>"><i class="fa fa-download" aria-hidden="true"></i></button></td>
                <td><input type="hidden" name="edit<?= $item["id"]?>"><i class="fa fa-pencil" aria-hidden="true"></i></td>
                <td><button type="submit" name="delete<?= $item["id"]?>"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
            </tr>
        <?php endforeach;?>
    </table>
</form>