<?php
function eventLogger($toLog)
{
	$archivoLog = 'logs/actions.log';
	$ipAddress = $_SERVER['REMOTE_ADDR'];
	$archivo = fopen($archivoLog, 'a');
	$fechaHora = date('Y-m-d H:i:s');
	$toLogD = "" . $ipAddress. " " . $toLog;
	$mensajeLog = "[$fechaHora] $toLogD\n";
	fwrite($archivo, $mensajeLog);
	fclose($archivo);
}
