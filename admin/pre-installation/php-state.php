<?php
//Check state of PHP
if( ini_get("safe_mode") )
{
  $error=true;
  $safe_mode_error="Please switch of PHP Safe Mode";
}

//Check if mail is enabled
if(!function_exists('mail'))
{
  $mail_error="PHP Mail function is not enabled!";
}