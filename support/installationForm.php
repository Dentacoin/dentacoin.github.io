<?php
// URL: www.freecontactform.com
// Version: Responsive Contact Form V3 - Installer
// Copyright (c) 2018 Stuart Cochrane
// 
// NOTE: This script may only be used to install your software
//       You are not licensed to use this for any other purpose
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
// THE SOFTWARE.
define('INSTALLFILE', 'installationForm.php');
define('CONFIGFILE', 'formConfiguration.php');
define('FORMFILE', 'contactForm.htm');
define('ABSPATH', dirname(__FILE__) . '/');

error_reporting(E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);

$install_complete = 'OK, Installation complete. <br /><br /><a href="' . FORMFILE . '">Visit your form</a>. <br /><br />To reinstall, delete the file: ' . CONFIGFILE . ' then run <a href="' . INSTALLFILE . '">this installer again</a>.';

if (file_exists(ABSPATH . CONFIGFILE)) {
    echo $install_complete;
    exit(0);
}

$fields = array(
    "EMAIL",
    "SUBJECT",
    "TYPE",
    "USESMTP",
    "HOST",
    "USER",
    "PASS",
    "PORT",
    "USESMTP",
    "USERECAPTCHA",
    "SITEKEY",
    "PRIVATEKEY",
    "USEGDPR");

$config_template = '<?php

// enter the email address of where
// you want to receive the form submissions
$email_to = "{EMAIL}";

// enter the email subject line
$email_subject = "{SUBJECT}";

// Use HTML email or Plain text
// Set value to "HTML" or "Plain"
$email_type = "{TYPE}";

// Use SMTP or try and use your servers default emailer
// set value to "yes" or "no"
$use_smtp = "{USESMTP}";

// Use your own SMTP setting 
// or a free smtp hosts (mandrill.com, sendgrid.com or gmail.com)
$smtp_host = "{HOST}";
$smtp_username = "{USER}";
$smtp_password = "{PASS}";
$smtp_port = "{PORT}";

// Use ReCAPTCHA V2
// Generate your keys at: https://www.google.com/recaptcha/intro/index.html
// set value to "yes" or "no"
$use_recaptcha = "{USERECAPTCHA}";
$sitekey = "{SITEKEY}";
$privatekey = "{PRIVATEKEY}";

// If you have problems getting SMTP to work
// switch on debugging output
// set value to "yes" or "no"
$smtp_debug = "no";

// If you require "ssl" or "tls", set the value below
$smtp_secure = "";

// If you want to capture the users IP address
// set this to "yes" or set it to "no"
$show_users_ip = "yes";

// Use GDPR or require consent
$use_gdpr = "{USEGDPR}";';


$form_template = '<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css" rel="stylesheet">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        {RECAPTCHASCRIPT}
        <script src="js/{jsValidator}.js"></script>
        <style>body { margin: 30px; } .bottom-align-text {position: absolute; bottom: 0; right: 0;}</style>
    </head>
    <body>
    <div style="width:98%;max-width:500px;">
        <form id="contactForm" class="form-horizontal" method="post" action="formProcess.php">
            <fieldset class="col-sm-12">
                <legend>Contact Form</legend>
                <div class="form-group">
                    <label for="Name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                            <input type="text" id="Name" name="Name" class="form-control" placeholder="* Enter Name">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                            <input type="email" id="Email" name="Email" class="form-control" placeholder="* Enter Email">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Phone" class="col-sm-2 control-label">Phone</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                            <input type="text" id="Phone" name="Phone" class="form-control" placeholder="Enter Phone Number">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Message" class="col-sm-2 control-label">Message</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-comment fa-fw"></i></span>
                            <textarea id="Message" name="Message" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                {GDPR_ROW}
                {RECAPTCHASITEKEY}
                <div class="form-group">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10" align="center">
                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </div>
            </fieldset>
        </form>
        <div id="status"></div>
    </div>
    </body>
</html>';

$error_strings = array();

if (isset($_POST['EMAIL'])) {
    installForm($config_template, $form_template, $install_complete, $fields);
    exit();
}

function installForm($config_template, $form_template, $install_complete, $fields) {

    global $error_strings;
    
    if (!file_exists(ABSPATH . CONFIGFILE)) {

        setDefaults($fields);
        $search = getSearch($fields);
        $replace = getReplace($fields);
        createFile($search, $replace, $config_template, ABSPATH . CONFIGFILE);
        
        $search = array("{RECAPTCHASCRIPT}", "{RECAPTCHASITEKEY}");
        $replace = array(" ", " ");
        if (isset($_POST['USERECAPTCHA']) && $_POST['USERECAPTCHA'] == "yes") {
            $replace = array(
                '<script src="https://www.google.com/recaptcha/api.js"></script>',
                '<div class="form-group">
                <div class="col-sm-2"></div>
                <div class="col-sm-10" align="center">
                <div class="g-recaptcha" data-sitekey="' . $_POST['SITEKEY'] . '"></div>
                </div>
                </div>');
        }

        if(isset($_POST['USEGDPR']) && $_POST['USEGDPR'] == "yes") {

            $search[] = "{GDPR_ROW}";
            $replace[] = '<div class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-10" align="center">
            <input type="checkbox" name="Consent" value="given"> I agree to be contacted in response to my message
            </div>
        </div>';

            $search[] = "{jsValidator}";
            $replace[] = "formValidatorConsent";
        } else {
            $search[] = "{GDPR_ROW}";
            $replace[] = " ";
            $search[] = "{jsValidator}";
            $replace[] = "formValidator";
        }

        createFile($search, $replace, $form_template, ABSPATH . FORMFILE);
    }

    if (count($error_strings) > 0) {
        echo "Number of errors: ".count($error_strings)."<br />";
        foreach ($error_strings as $es) {
            echo "$es <br />";
        }
    } else {
        echo $install_complete;
    }
}


function createFile($search, $replace, $template, $filename) {
    global $error_strings;
    $file_contents = str_replace($search, $replace, $template);
    if (!$handler = fopen($filename, "wb")) {
        $error = true;
    } else {
        if (!fwrite($handler, trim($file_contents))) { $error = true; }
        fclose($handler);
    }
    if($error) {
        $viewable_code = nl2br(str_replace("<", "&lt;", $file_contents));
        $error_strings[] = "Cannot write your file to: $filename - Please change the directory permissions to allow write access.<br /><br /> 
      If you prefer, you can create the file using the code below:<br /><br />" . $viewable_code . "<br /><br />Save the above code to a new file at: $filename";
    }
}


function setDefaults($fields) {
    foreach ($fields as $field) {
        if (!isset($_POST[$field])) {
            $_POST[$field] = "";
        }
    }
}

function getSearch($fields) {
    $search = array();
    foreach ($fields as $field) {
        $search[] = '{' . $field . '}';
    }
    return $search;
}

function getReplace($fields) {
    $replace = array();
    foreach ($fields as $field) {
        $replace[] = $_POST[$field];
    }
    return $replace;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Installation Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css" rel="stylesheet">

        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="js/formValidatorInstallation.js"></script>

        <style>body { margin: 30px; }</style>
    </head>
    <body>
        <div style="width:98%;max-width:550px;">
            <form id="installationForm" class="form-horizontal" method="post" action="<?php echo INSTALLFILE; ?>">
                <fieldset class="col-sm-12">
                    <legend>Installation Form</legend>

                    <div class="form-group">
                        <label for="EMAIL" class="col-sm-3 control-label">Email to</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-edit fa-fw"></i></span>
                                <input type="email" id="EMAIL" name="EMAIL" class="form-control" placeholder="* Email to">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="SUBJECT" class="col-sm-3 control-label">Email subject</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-edit fa-fw"></i></span>
                                <input type="text" id="SUBJECT" name="SUBJECT" class="form-control" placeholder="* Enter subject" value="Message from website">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="TYPE" class="col-sm-3 control-label">Email type</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul fa-fw"></i></span>
                                <select id="TYPE" name="TYPE" class="form-control">
                                    <option value="HTML">HTML</option>
                                    <option value="Plain">Plain text</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="USESMTP" class="col-sm-3 control-label">Use SMTP</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul fa-fw"></i></span>
                                <select id="USESMTP" name="USESMTP" class="form-control">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="smtp_options">

                        <div class="form-group">
                            <label for="HOST" class="col-sm-3 control-label">SMTP Host</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-edit fa-fw"></i></span>
                                    <input type="text" id="HOST" name="HOST" class="form-control" placeholder="Smtp host">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="USER" class="col-sm-3 control-label">SMTP User</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-edit fa-fw"></i></span>
                                    <input type="text" id="USER" name="USER" class="form-control" placeholder="Smtp username">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="PASS" class="col-sm-3 control-label">SMTP Pass</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-edit fa-fw"></i></span>
                                    <input type="password" id="PASS" name="PASS" class="form-control" placeholder="Smtp password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="PORT" class="col-sm-3 control-label">SMTP Port</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-edit fa-fw"></i></span>
                                    <input type="text" id="PORT" name="PORT" class="form-control" placeholder="Smtp port" value="587">
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="form-group">
                        <label for="USERECAPTCHA" class="col-sm-3 control-label">Use ReCAPTCHA</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul fa-fw"></i></span>
                                <select id="USERECAPTCHA" name="USERECAPTCHA" class="form-control">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div id="recaptcha_options">

                        <div class="form-group">
                            <label for="SITEKEY" class="col-sm-3 control-label">Site Key</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-edit fa-fw"></i></span>
                                    <input type="text" id="SITEKEY" name="SITEKEY" class="form-control" placeholder="ReCAPTCHA V2 Site Key">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="PRIVATEKEY" class="col-sm-3 control-label">Private Key</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-edit fa-fw"></i></span>
                                    <input type="text" id="PRIVATEKEY" name="PRIVATEKEY" class="form-control" placeholder="ReCAPTCHA V2 Private Key">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="USEGDPR" class="col-sm-3 control-label">Required consent (GDPR compliant)</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul fa-fw"></i></span>
                                <select id="USEGDPR" name="USEGDPR" class="form-control">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-lg pull-right">Install Now</button>
                        </div>
                    </div>

                </fieldset>
            </form>
            <div id="status"></div>
        </div>
    </body>
</html>