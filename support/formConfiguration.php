<?php

// enter the email address of where
// you want to receive the form submissions
$email_to = "sample@email.tst";

// enter the email subject line
$email_subject = "Message from website";

// Use HTML email or Plain text
// Set value to "HTML" or "Plain"
$email_type = "HTML";

// Use SMTP or try and use your servers default emailer
// set value to "yes" or "no"
$use_smtp = "no";

// Use your own SMTP setting 
// or a free smtp hosts (mandrill.com, sendgrid.com or gmail.com)
$smtp_host = "1";
$smtp_username = "ieejssrh";
$smtp_password = "g00dPa$$w0rD";
$smtp_port = "587";

// Use ReCAPTCHA V2
// Generate your keys at: https://www.google.com/recaptcha/intro/index.html
// set value to "yes" or "no"
$use_recaptcha = "no";
$sitekey = "http://www.vulnweb.com";
$privatekey = "1";

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
$use_gdpr = "no";