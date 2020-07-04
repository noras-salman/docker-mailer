<?php 
error_reporting(0);
/** Require lib */
require(__DIR__.'/../lib/config.php');
require(__DIR__.'/../lib/mailer/Mailer.php');
require(__DIR__.'/../lib/Template.php');

/** Require core */
require_once(__DIR__."/restful/Api.php");
require_once(__DIR__."/v1/MailResource.php");





$api=new Api();
$api->addResource("mail",new MailResource());
$api->build();

 
?>