<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

<!-- LOGIN--------------------------------- -->
<?php
session_start();
$username="123";
$password="123";

if($_POST['username'] == $username && $_POST['password'] == $password){
    header( 'Location:index.php' );
}
else
{
?>

        <form  action="index.php" method='POST' >
            <label for='username' >UserName:</label>
            <input type='text' placeholder="123" name='username'  maxlength="50" />
            <label for='password' >Password:</label>
            <input type='text' name='password' placeholder="123" maxlength="50" />
            <input type='submit' name='submit' value='Submit' />
           
        </form>

<?php

}
?>



<!-- CREATE FOLDER------------------------------ -->
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

<!-- MAIN------------------------ -->

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
                '</td><td>
                <form action="" method="POST">
                <input type="hidden" name="delete" value="' . $file . '">
                <button class="del_btn" type="submit">Delete</button>
            </form>
        
        </td></tr>');
        }
    }

    print('</table>');
    
    // DELETE BUTTON-------------------

    if (isset($_POST['delete'])) {
        $delete_file = $_GET['path'] . "/" . $_POST['delete'];
                unlink($delete_file);
                
            }
    



    // BACK BUTTON--------------------
    
    function back_button($url) {
        $url = dirname($_SERVER['REQUEST_URI']);
        print("<div><button><a href='$url'>BACK</a></button></div>");
    }
    back_button($url_back_2);
    ?>



    




</body>

</html>