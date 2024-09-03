<?php
function my_autoload($pClassName)
{
	include('../Class' . "/" . $pClassName . ".class.php");
}

spl_autoload_register("my_autoload");

$cdi  = new cdi();
$res = $cdi->Rentabilidade();
echo json_encode($res);