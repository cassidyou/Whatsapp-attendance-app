<?php 
include_once "classes/functions-class.php";
$contrl = new Function_bank;
 $year = Date('Y');

 $jan = $contrl->get_monthly_stats($year."-01-01", $year."-01-31", $_SESSION["id"]);
 $feb = $contrl->get_monthly_stats($year."-02-01", $year."-02-31", $_SESSION["id"]);
 $mar = $contrl->get_monthly_stats($year."-03-01", $year."-03-31", $_SESSION["id"]);
 $apr = $contrl->get_monthly_stats($year."-04-01", $year."-04-31", $_SESSION["id"]);
 $may = $contrl->get_monthly_stats($year."-05-01", $year."-05-31", $_SESSION["id"]);
 $jun = $contrl->get_monthly_stats($year."-06-01", $year."-06-31", $_SESSION["id"]);
 $jul = $contrl->get_monthly_stats($year."-07-01", $year."-07-31", $_SESSION["id"]);
 $aug = $contrl->get_monthly_stats($year."-08-01", $year."-08-31", $_SESSION["id"]);
 $sep = $contrl->get_monthly_stats($year."-09-01", $year."-09-31", $_SESSION["id"]);
 $oct = $contrl->get_monthly_stats($year."-10-01", $year."-10-31", $_SESSION["id"]);
 $nov = $contrl->get_monthly_stats($year."-11-01", $year."-11-31", $_SESSION["id"]);
 $dec = $contrl->get_monthly_stats($year."-12-01", $year."-12-31", $_SESSION["id"]);

 ?>