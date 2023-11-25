<?php
function eventLogger($toLog)
{
	$archivoLog = 'logs/actions.log';
	$ipAddress = $_SERVER['REMOTE_ADDR'];
	$archivo = fopen($archivoLog, 'a');
	$fechaHora = date('Y-m-d H:i:s');
	$toLogD = " " . $ipAddress . $toLog;
	$mensajeLog = "[$fechaHora] $toLogD\n"; // Use $toLog instead of $mensaje
	fwrite($archivo, $mensajeLog);
	fclose($archivo);
}
