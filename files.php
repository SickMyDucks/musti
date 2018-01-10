<?php $folder = array_diff(scandir("users/".$_SESSION['username']), array('..', '.'));?>
<form action="index.php" method="POST" enctype="multipart/form-data">
    <label for="upload">Upload a file : </label><input type="file" name="upload" id="upload" required><br>
    <input type="submit" value="Send">
    <div class="logs"><?php if (isset($logs)){echo $logs;}?></div>
</form>
<form action="index.php" method="POST" id="files" enctype="multipart/form-data">
    <table>
    <?php if (count($folder) == 0):?>
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
        <?php for ($i = 2; $i < count($folder) + 2; $i++):?>
            <tr>
                <td><i class="fa fa-file" aria-hidden="true"></i></td>
                <td><span><?= htmlentities($folder[$i])?></span></td>
                <td><?= date ("d/n/Y - H:i:s", filemtime("users/".$_SESSION['username']."/".$folder[$i]))?></td>
                <td><button type="submit" class="download" form="files"><i class="fa fa-download" aria-hidden="true" id="download<?=$i?>"></i></button></td>
                <td><input type="hidden"><i class="fa fa-pencil" aria-hidden="true" id="edit<?=$i?>"></i></td>
                <td><button type="submit" class="delete" form="files"><i class="fa fa-trash" aria-hidden="true" id="delete<?=$i?>"></i></button></td>
            </tr>
        <?php endfor;?>
    </table>
</form>
