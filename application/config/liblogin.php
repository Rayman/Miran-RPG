<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Salt Key.
|--------------------------------------------------------------------------
|
| Generate a salt key from the following website: 
| https://www.grc.com/passwords.htm
|
*/
$config['auth']['salt']	= 'uVDMOgMJWiks5ucY1xYGHQhXiZmz4H1kJVFVUPrpjEMG2qCRd0QzHtVEfkVaN9y';

/*
|--------------------------------------------------------------------------
| Tables
|--------------------------------------------------------------------------
*/
$config['auth']['users_table'] 		= 'users';

/*
|--------------------------------------------------------------------------
| Email Activation
|--------------------------------------------------------------------------
|
| When this is set to true, the user will be required to 
| activate their account before they are allowed to login.
|
*/
$config['auth']['email_activation'] = false;

/*
|--------------------------------------------------------------------------
| Email Settings
|--------------------------------------------------------------------------
|
| 'mailtype' : text or html.
| 'protocol' : The mail sending protocol.
| 'smtp_host' : SMTP Server Address.
| 'smtp_user' : SMTP Username.
| 'smtp_pass' : SMTP Password.
| 'smtp_port' : SMTP Port.
| 'mail_from_email' : Sets the email address of the person sending the email
| 'mail_from_namae' : Sets the name of the person sending the email
*/
$config['auth']['mail']['mailtype']	= 'html';
$config['auth']['mail']['protocol'] 	= 'smtp';
$config['auth']['mail']['smtp_host'] 	= ''; 
$config['auth']['mail']['smtp_user'] 	= '';
$config['auth']['mail']['smtp_pass'] 	= ''; 
$config['auth']['mail']['smtp_port'] 	= '';
$config['auth']['mail_from_email'] 	= '';
$config['auth']['mail_from_name'] 	= '';

/*
|--------------------------------------------------------------------------
| Email Activation Message Settings
|--------------------------------------------------------------------------
|
| {activation_code} will be replaced with the users email activation code.
|
*/
$config['auth']['email_activation_subject'] = 'Website.com Email Activation';

$config['auth']['email_activation_message'] = <<<HTML

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		
	</head>
	<body>
		<h2>Email Activation</h2>
		<p>Your email activation code is : {activation_code}</p>
	</body>
</html>

HTML;

/*
|--------------------------------------------------------------------------
| Forgotten Password Message Settings
|--------------------------------------------------------------------------
|
| {key} will be replaced with the email verification code.
|
*/
$config['auth']['forgotten_password_subject'] = 'Website.com Forgotten Password Request';

$config['auth']['forgotten_password_message'] = <<<HTML

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		
	</head>
	<body>
		<h2>Forgotten Password Request</h2>
		<p>Your verification code is : {key}</p>
	</body>
</html>

HTML;

/*
|--------------------------------------------------------------------------
| New Password Message Settings
|--------------------------------------------------------------------------
|
| {password} will be replaced with the new password.
|
*/
$config['auth']['new_password_subject'] = 'Website.com Your New Password';

$config['auth']['new_password_message'] = <<<HTML

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		
	</head>
	<body>
		<h2>Your New Password</h2>
		<p>Your new password is : {password}</p>
	</body>
</html>

HTML;

