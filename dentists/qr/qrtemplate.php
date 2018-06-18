<!DOCTYPE html>
<html lang="en" class="wide wow-animation">
    <head>
        <?php
            //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'H';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 8;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_REQUEST['data'])) { 
    
        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } 
        ?>
        <style>
            @page {
                size: auto;
                margin: 0;
            }
        </style>
        <link rel="icon" href="https://dentacoin.com/web/img/favicon.ico" type="image/x-icon">
    </head>
    <body onload="window.print()">
        <div style="width: 777px; height: 1090px;">
            <div style="width: 777px; height: 1090px; position: absolute;"><img style="width: 777px; height: 1090px; position: absolute;" src="pics/background.jpg" alt=""></div>
            <div style="width: 777px; height: 1090px; position: absolute;"><img style="width: 777px; height: 1090px; position: absolute;" src="pics/background1.png" alt=""></div>
            <div style="width: 777px; height: 1090px; position: absolute;"><img style="width: 777px; height: 1090px; position: absolute;" src="pics/element1.png" alt=""></div>
            <div style="width: 777px; height: 1090px; position: absolute;"><img style="width: 777px; height: 1090px; position: absolute;" src="pics/text1.png" alt=""></div> 
            <div style="width: 777px; height: 1090px; position: absolute;"><img style="width: 777px; height: 1090px; position: absolute;" src="pics/text2.png" alt=""></div>   
            <div style="margin-left: 226px; padding-top: 510px;"><?php echo '<img style="position: absolute;" src="'.$PNG_WEB_DIR.basename($filename).'" />';?></div> 
        </div>
    </body>
</html>
        