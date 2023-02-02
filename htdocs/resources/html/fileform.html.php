<h1>File Manager</h1>
<script src=<?= $scriptSrc?>></script>


<form action='index.php' method="POST" enctype="multipart/form-data">
<label>Dodaj Plik</label><br />
<input type='hidden' name='fileSend' value='1'>
<label>piętro:</label><br />
<select name='fileName'>
<?php if (isset($floors))
    foreach ($floors as $floor)
    {
        echo '<option value="'.$floor[2].'"> Budynek: '.$floor[1].' Piętro:'.$floor[0].'</option>\n';
    }
?>  
</select>
<br />
<input type='file' name='userFile'><br />
<input type="submit" name="page" value="Formularz Plików">
</form>
Status: <?php if (isset($saveStatus))
    echo $saveStatus;
?>
<br /><br />
<form action='index.php' method="POST" enctype="multipart/form-data">
<label>Usuń Plik</label><br />
<select name="fileName" id="files">
<?php if (isset($files))
    $skipList = [".", ".."];
    foreach ($files as $name)
    {
        if (in_array($name, $skipList))
            continue;

        echo '<option value="'.$name.'">'.$name.'</option>\n';
    }
?>
</select>
<input type='hidden' name='fileSend' value='2'>
<input type="submit" name="page" value="Formularz Plików"><br />
</form>
Status: <?php if (isset($removeStatus))
    echo $removeStatus;
?>

