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
        justify-content: space-between;
        margin: 50px;

    }
</style>

<body>
    <?php

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
    $path = './' . $_GET['path'];


    function display($files_and_dirs)
    {
        $path = './' . $_GET['path'];
        $files_and_dirs = scandir($path);

        print('<table><th>Type</th><th>Name</th><th>Actions</th>');
        foreach ($files_and_dirs as $fnd) {
            if ($fnd != ".." and $fnd != ".") {
                print('<tr>');
                print('<td>' . (is_dir($fnd) ? "Directory" : "File") . '</td>');
                print('<td>' .
                    '<a href="' . (is_dir($fnd) ? ((isset($_GET['path'])) ? $_SERVER['REQUEST_URI'] . $fnd . '/' : $_SERVER['REQUEST_URI'] . '?path=' . $fnd . '/') :  $fnd) . '">' . $fnd . '</a>');
                print('</td></tr>');
                
            }
        }
        print("</table>");
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

    // function back($url){
    // $url = htmlspecialchars($_SERVER['HTTP_REFERER']);
    // echo "<a href='$url'>back</a>"; 
    // }
    

  function back_url($url_back_2){
        $url_back_2 = dirname($_SERVER['REQUEST_URI']);
        print("<a href='$url_back_2'>GO BACK</a>");
  }
    


  print_r($_POST).'<br>';
    print_r((__FILE__).'<br>');
    print_r(dirname(__FILE__).'<br>');
    print_r($_SERVER['REQUEST_URI'].'<br>');
    print(dirname($_SERVER['REQUEST_URI']).'<br>');

    
    ?>


  



    <?php
    display($files_and_dirs);


    ?>

<!-- -------------HTML -->
<br>
   <div class="create_back">
   
    <form action="" method="POST">
        <input type="text" name="create">
        <input type="submit" value="Create directory">

    </form>

    
    <button><?php echo back_url($url_back_2)?></button>
</div>

</body>

</html>