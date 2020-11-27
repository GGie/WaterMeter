<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| EMAIL CONFING
| -------------------------------------------------------------------
| Configuration of outgoing mail server.
| */

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'mail.cahayajakarta.com';
//$config['smtp_host'] = 'secure.emailsrvr.com';
$config['smtp_port'] = '26';
$config['smtp_timeout'] = '30';
$config['smtp_user'] = 'support@cahayajakarta.com';
$config['smtp_pass'] = 'c4hayajkt';
$config['charset'] = 'utf-8';
$config['mailtype'] = 'html';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n";

// custom values from CodeIgniter Bootstrap
$config['from_email'] = "support@cahayajakarta.com";
$config['from_name'] = "Support";
$config['subject_prefix'] = "Pemberitahuan:";

/*
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['smtp_port'] = '465';
$config['smtp_timeout'] = '30';
$config['smtp_user'] = 'anggietriejast@gmail.com';
$config['smtp_pass'] = 'intannuraeni01';
$config['charset'] = 'utf-8';
$config['mailtype'] = 'html';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n";

// custom values from CodeIgniter Bootstrap
$config['from_email'] = "anggietriejast@gmail.com";
$config['from_name'] = "Support";
$config['subject_prefix'] = "Pemberitahuan:";
*/
/* End of file email.php */
/* Location: ./system/application/config/email.php */