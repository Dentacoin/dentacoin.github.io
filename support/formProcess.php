<?php
if(!isset($_POST['Name'])) {
    exit(0);
}

define('CONFIGFILE', 'formConfiguration.php');
define('VALIDATEFILE', 'formValidator.php');
define('PHPMAILER', 'class.phpmailer.php');
define('PHPMAILERSMTP', 'class.smtp.php');
define('EMAILTEMPLATEFILE', 'emailTemplate.html');

// check all fields have been supplied by the form
$form_fields = array(
    "Name" => "NOT_EMPTY",
    "Email" => "EMAIL",
    "Message" => "NOT_EMPTY"
);

checkConfigurationExists();

checkFieldsExist($form_fields);

validateFields($form_fields);

checkRecaptcha();

sendEmail();


function checkConfigurationExists() {
    if (!file_exists( dirname(__FILE__).'/'.CONFIGFILE) ) {
        echo "Form configuration does not exist. If you're the webmaster - please see installation instructions";
        exit(1);
    }
}

function checkFieldsExist($form_fields) {
    $errors = 0;
    foreach($form_fields as $field => $type) {
        if(!isset($_POST[$field])) {
            $errors++;
        }
    }
    if($errors > 0) {
        echo "Sorry, There's a problem reading the form fields.";
        exit(1);
    }
}

function checkRecaptcha() {
    require CONFIGFILE;
    if(isset($_POST['g-recaptcha-response']) && $use_recaptcha == "yes"){
        if($_POST['g-recaptcha-response']) {
            $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$privatekey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
            if(!strstr($response, "true")){
                echo "Sorry, There's a problem with the anti-spam reCaptcha.";
                exit(1);
            }
        } else {
            echo "Sorry, There's a problem with the anti-spam reCaptcha.";
            exit(1);
        }
    }
}

function validateFields($form_fields) {
    require_once VALIDATEFILE;

    $validate = new FormValidate;
    
    foreach($form_fields as $field => $type) {
        $validate->validate($field, $_POST[$field], $type);
    }
    
    if($validate->anyErrors()) {
        echo "Please fix the following errors.<br />";
        echo "<ul>";
        echo $validate->getErrorString();
        echo "</ul>";
        exit(1);
    }
}

function sendEmail() {
    
    require CONFIGFILE;
    require_once PHPMAILER;
    require_once PHPMAILERSMTP;
    
    $isHTML = getEmailType($email_type);
    $isDebug = getDebugType($smtp_debug);
    $showIP = getIPType($show_users_ip);
    $isSMTP = getIsSmtp($use_smtp);
    
    $plain_body = getPlainBody($showIP);
    $html_body = getHtmlBody($isHTML, $showIP);
  
    $mail = new PHPMailer;

    if($isDebug) {
        $mail->SMTPDebug = 3;
    }
    
    if($isSMTP) {
        $mail->isSMTP();
        $mail->Port = $smtp_port;
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = $smtp_secure;
        $mail->Username = $smtp_username;            
        $mail->Password = $smtp_password;                         
    }
    
    $mail->From = $_POST['Email']; 
    $mail->FromName = $_POST['Name']; 
    $mail->addAddress($email_to, $email_to);   
    $mail->addReplyTo($email_to, $email_to);

    $mail->WordWrap = 50;                               
    $mail->Subject = $email_subject;
    
    if($isHTML) {
        $mail->isHTML(true);                                
        $mail->Body = $html_body;
        $mail->AltBody = $plain_body;
    } else {
        $mail->Body = $plain_body;
    }
    
    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'OK.<br />Thank you, we\'ve received your message.';
    }
    exit(0);
}

function getEmailType($email_type) {
    $isHTML = false;
    if(strtoupper($email_type) == "HTML") {
        $isHTML = true;
    }
    return $isHTML;
}

function getDebugType($smtp_debug) {
    $isDebug = false;
    if(strtoupper($smtp_debug) == "YES") {
        $isDebug = true;
    }
    return $isDebug;
}

function getIPType($show_users_ip) {
    $showIP = false;
    if(strtoupper($show_users_ip) == "YES") {
        $showIP = true;
    }
    return $showIP;
}

function getIsSmtp($use_smtp) {
    $isSMTP = false;
    if(strtoupper($use_smtp) == "YES") {
        $isSMTP = true;
    }
    return $isSMTP;
}

function getHtmlBody($isHTML, $showIP) {
    if($isHTML) {
        $html_template = file_get_contents('./'.EMAILTEMPLATEFILE);
        $html = "";
        foreach($_POST as $field => $value) {
            if($field == "Challenge") { continue; }
            if($field == "g-recaptcha-response") { continue; }
                    
            $html .= "<tr><td style=\"padding-right:6px\">$field:</td><td>$value</td></tr>";
        }
        
        if($showIP) {
            $html .= "<tr><td style=\"padding-right:6px\">IP Address:</td><td>{$_SERVER['REMOTE_ADDR']}</td></tr>";
        }
        
        $html_body = str_replace("{EMAIL_CONTENT}", $html, $html_template);
        return $html_body;
    }
    return "";
}

function getPlainBody($showIP) {
    $plain = "";
    foreach($_POST as $field => $value) {
        if($field == "Challenge") { continue; }
        $plain .= $field.": ".$value.PHP_EOL;
    }
    if($showIP) {
        $plain .= "IP Address: {$_SERVER['REMOTE_ADDR']}";
    }
    return $plain;
}