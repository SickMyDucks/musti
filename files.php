<?php 
    $q = "SELECT file_name, modified_last FROM files WHERE owned_by_user_id = '". $_SESSION['id'] . "'";
    $result = mysqli_query($link, $q);
    $data = [];
    while ($row = mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
?>
    <table border="0">
    <?php foreach ($data as $article):?>
        <tr>
            <td><i class="fa fa-file" aria-hidden="true"></i></td>
            <td><?= $article["file_name"]?></td>
            <td><?= $article["modified_last"]?></td>
            <td><i class="fa fa-download" aria-hidden="true"></i></td>
            <td><i class="fa fa-pencil" aria-hidden="true"></i></td>
            <td><i class="fa fa-trash" aria-hidden="true"></i></td>
        </tr>
    <?php endforeach; 
    //$files = ob_get_contents();
    //ob_end_clean();
    ?>
    </table>

<!-- <table>
    <tr>
        <td></td>
        <td>Modified : </td>
    </tr>
</table> -->


