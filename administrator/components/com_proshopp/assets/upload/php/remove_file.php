<?php 
if(isset($_POST['file'])){
    $file = $_POST["dest"] . $_POST['file'];
    echo file_exists($file);
    if(file_exists($file)){
        unlink($file);
    }
}
?>