<?php
session_start();
?>
<?php
if(isset($_GET['action']) && $_GET['action'] == 'logout'){
    
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['logged_in']);
    print('Logged out!');
}

  if (isset($_POST['login']) && !empty($_POST['username'])  && !empty($_POST['password'])) {
    // įhardcodinti prisijugimo duomenys
          if ($_POST['username'] == '123' && $_POST['password'] == '123') {
             $_SESSION['logged_in'] = true;
             $_SESSION['timeout'] = time(); // galime valdyti laiką, kada vartotojo sesiją sunaikinti jei kūrimo metu jį išsisaugome
             $_SESSION['username'] = 'Tomas';
             echo 'You have entered valid use name and password';
          } else {
             $msg = 'Wrong username or password';
          }
       }


      




   
// grgr


       
// $path = './' . $_GET['path'];
// $files_and_dirs = scandir($path);

// print('<h2>Directory contents: ' . str_replace('?path=','',$_SERVER['REQUEST_URI']) . '</h2>');

// // List all files and directories
// print('<table><th>Type</th><th>Name</th><th>Actions</th>');
// foreach ($files_and_dirs as $fnd){
//     if ($fnd != ".." and $fnd != ".") {
//         print('<tr>');
//         print('<td>' . (is_dir($fnd) ? "Directory" : "File") . '</td>');
//         print('<td>' . (is_dir($fnd) 
//                     ? '<a href="' . (isset($_GET['path']) 
//                             ? $_SERVER['REQUEST_URI'] . $fnd . '/' 
//                             : $_SERVER['REQUEST_URI'] . '?path=' . $fnd . '/') . '">' . $fnd . '</a>'
//                     : $fnd) 
//             . '</td>');
//         print('<td></td>');
//         print('</tr>');
//     }
// }
// print("</table>");




function display($files_and_dirs){
    $path = './' . $_GET['path'];
    $files_and_dirs = scandir($path);

    print('<table><th>Type</th><th>Name</th><th>Actions</th>');
    foreach ($files_and_dirs as $fnd) {
        if ($fnd != ".." and $fnd != ".") {
            print('<tr>');
            print('<td>' . (is_dir($fnd) ? "Directory" : "File") . '</td>');
            print('<td>' .
                '<a href="' . (is_dir($fnd) ? ((isset($_GET['path'])) ? $_SERVER['REQUEST_URI'] . $fnd . '/' : $_SERVER['REQUEST_URI'] . '?path=' . $fnd . '/') :  $fnd) . '">' . $fnd . '</a></td>');
            print('<td>
                    <form action="" method="POST">
                    <input type="hidden" name="delete" value="' . $fnd . '">
                    <input type="submit" value="delete">
                    </form>');
                    if(is_file($fnd)){
                        print('<form action="" method="POST">
                        <input type="hidden" name="download" value="' . $fnd . '">
                        <button class="downl_btn" type="submit">Download</button>
                    </form>');
                    }
            
            print('</td></tr>');
            
        }
    }
    print("</table>");
}
    // $file_ext = strtolower(end(explode('.', $_POST['delete'])));
    // $extensions = array("css","gitattributes","gitignore","gitkeep");
    // if(in_array($file_ext,$extensions) === true){


//delete file or folder
if(isset($_POST['delete'])){
    $deleted_file=$_POST['delete'];
    if(is_dir($_POST['delete'])){
        rmdir($deleted_file);
    } else {
    
        unlink($deleted_file);
}
}


//create folder
if (isset($_POST['create'])) {
    $new_folder = $path . $_POST['create'];
    if (is_dir($new_folder)) {
        echo 'Directory exist';
    } else {
        mkdir($new_folder);
    }
}


    if(isset($_FILES['image'])){
        $errors= array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        // check extension (and only permit jpegs, jpgs and pngs)
        $file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));
        $extensions = array("jpeg","jpg","png");
        if(in_array($file_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        if($file_size > 2097152) {
            $errors[]='File size must be excately 2 MB';
        }
        if(empty($errors)==true) {
            move_uploaded_file($file_tmp,$_GET['path'].$file_name);
            echo "Success";
        }else{
            print_r($errors);
        }
    }


      // file download logic
      if(isset($_POST['download'])){
        // print('Path to download: ' . './' . $_GET["path"] . $_POST['download']);
        $file='./' . $_GET["path"] . $_POST['download'];
        // a&nbsp;b.txt
        // a b.txt
        $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
        ob_clean();
        ob_start();
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf'); // mime type → ši forma turėtų veikti daugumai failų, su šiuo mime type. Jei neveiktų reiktų daryti sudėtingesnę logiką
        header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileToDownloadEscaped)); // kiek baitų browseriui laukti, jei 0 - failas neveiks nors bus sukurtas
        ob_end_flush();
        readfile($fileToDownloadEscaped);
        exit;
    }


// function back($url){
// $url = htmlspecialchars($_SERVER['HTTP_REFERER']);
// echo "<a href='$url'>back</a>"; 
// }

//back button
function back_url($url_back_2){
    $url_back_2 = dirname($_SERVER['REQUEST_URI']);
    print("<a href='$url_back_2'>GO BACK</a>");
}




// print_r($_POST).'<br>';
//     print_r((__FILE__).'<br>');
//     print_r(dirname(__FILE__).'<br>');
//     print_r($_SERVER['REQUEST_URI'].'<br>');
//     print(dirname($_SERVER['REQUEST_URI']).'<br>');

// $sakinys = 'Lokomotyvas yra toli';
// $dalys =strtolower(end(explode('.', $_POST['delete'])));
//     print_r($dalys);

?>
<pre>
<?php
print_r($_FILES);
?>
</pre>







<?php
// display($files_and_dirs);

//cookie
setcookie("counter","Tomas",time()+3600,"/","",0);
session_start();
if(isset($_SESSION['counter'])){
    $_SESSION['counter']+=1;

}else{
    $_SESSION['counter']=1;
}


?>



       
       

<!-- -------------HTML -->
<!DOCTYPE html>
<html>

<head>
    <title>File System Browser</title>
</head>
<style>
    * {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table td,
    table th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    table tr:hover {
        background-color: #ddd;
    }

    table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
    .create_back {
        
        display: flex;
        
        margin: 50px;

    }
    .create_back button{
        margin-left: 320px;
    }
</style>

<body>


        

<?php

if($_SESSION['logged_in'] == true){
        display($files_and_dirs);
 ?>

<div class="create_back">
   
    <form action="" method="POST">
        <input type="text" name="create">
        <input type="submit" value="Create directory">

    </form>

    
    <button><?php echo back_url($url_back_2)?></button>
</div>

<!-- //upload -->
<form action = "" method = "POST" enctype = "multipart/form-data">
        <input type = "file" name = "image" />
        <input type = "submit" value="upload"/>
    </form>
    <ul>
        <li>Sent file: <?php echo $_FILES['image']['name'];  ?>
        <li>File size: <?php echo $_FILES['image']['size'];  ?>
        <li>File type: <?php echo $_FILES['image']['type'] ?>
    </ul>


Click here to <a href = "index.php?action=logout"> logout.
<br>
<br>
YUO HAVE VISITED <?php print($_SESSION['counter']) ?>
<?php
} else { ?>
    

   
<form action="" method="post">
        <h4><?php echo $msg; ?></h4>
            <input type="text" name="username" placeholder="username = Mindaugas" required autofocus></br>
            <input type="password" name="password" placeholder="password = 1234" required>
            <button class = "btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
        </form>

       

<br>
   

<h3><?php echo $msg?></h3>
<?php
}
?>



</body>

</html>

