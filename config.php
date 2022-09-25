<?php 
require_once('classes/Db.php');
session_start();

$db = new Db_class;
$db->db_connect();







define('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'https://site.test/whatsapp-attendance/');



?>