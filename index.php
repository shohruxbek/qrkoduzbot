<?php 
if(isset($_GET['text'])){ 
$a = $_GET['text']; 
$id = $_GET['id']; 
 
Header("Content-type: image/png");


$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR."$id.png";
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
  
    
        //default data
        //echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
    QRcode::png("$a", $filename, 'L', 10, 2);    
         
        
    //display generated file


header ("location: ".$PNG_WEB_DIR.basename($filename)); 
//unlink($filename)
} 
?>
    