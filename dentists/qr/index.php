<?php    
/*
 * PHP QR Code encoder
 *
 * Exemplatory usage
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
    
    
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
    
    //config form
    echo '
        <head>
            <link rel="icon" href="https://dentacoin.com/web/img/favicon.ico" type="image/x-icon">
            <link rel="stylesheet" type="text/css" href="web/css/min.style.css">
        </head>
        <body>
            <section id="what" class="text-center section-100">
                <div class="range range-sm-center">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-md-offset-2 text-left h-blue">
                            <p style="font-size: 24px;" class="cell-sm-12 text-left text-blue">Insert your Address here</p>
                            <form action="qrtemplate.php" method="post">
                                <input name="data" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'').'" placeholder="0x0000000000000000000000000000000000000000" class="form-control text-white-05" required />
                                <input type="hidden" value="H" name="level" />
                                <input type="hidden" value="8" />
                                <div class="divider-fullwidth bg-porcelain"></div>
                                <div class="range offset-top-22">
                                    <div class="about-text cell-sm-6 cell-md-6 cell-lg-6 offset-top-0 offset-sm-top-0 offset-xl-top-0">
                                        <input type="submit" value="GENERATE" class="btn btn-primary btn-block offset-top-35" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </body>';
    // // benchmark
    // QRtools::timeBenchmark();    
