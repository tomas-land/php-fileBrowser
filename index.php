<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    
    $folder_name = $_POST['createfolder'];
    if (!file_exists($path . $folder_name)) {
        // $current_path = getcwd();
        @mkdir($folder_name, true);
    }
    ?>

    <form action="" method="post">
        <h2>
            Create New Folder
        </h2>
        <input name="createfolder" type="text">
        <input type="submit" value="Create Folder">
    </form>
    <br>

    <?php
    $path = isset($_GET['path']) ? $_GET['path'] : './';
    $files = scandir($path);
    print('<table>
        <tr>
            <th>Type</th>
            <th>Name</th>
            <th>Action</th>
        </tr>');

    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {

            print('<tr><td>');
            if (is_dir($file)) {
                echo 'directory';
            }
            print('</td>');
            
            print('<td>' .
                '<a href=?path=' . $path . $file . '>' . $file . '</a>' .
                '</td><td>');
        print('<form  method="POST">');
        print('<input type="submit" name="delete" value="Delete"/>');
        print('</form>');
        if(isset($_POST['delete'])){
            rmdir($file);
        }
        ('</td></tr>');
        }
    }

    print('</table>');
    echo getcwd() . "\n";
    // $file = $_GET['file'];
    // rmdir($file);
    ?>


    <input type="button" value="Back" onClick="history.back();return true;">




</body>

</html>