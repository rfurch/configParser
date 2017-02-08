#!/usr/bin/php
<?php
if(!isset($argv[2])) {
 die ("usage: ./scriptName router_ip username password\n");
}
$port = 23;
$timeout = 10;
$router_ip = $argv[1];
$username = $argv[2];
$password = $argv[3];
$password2 = $argv[4];

$connection = fsockopen($router_ip, $port, $errno, $errstr, $timeout);

if(!$connection){
 echo "Connection failed\n";
 exit();
} else {
 echo "Connected\n";
 fputs($connection, "$username\r\n");
 fputs($connection, "$password\r\n");
 fputs($connection, "en\r\n");
 fputs($connection, "$password2\r\n");
 fputs($connection, "term len 0\r\n");
 fputs($connection, "show version\r\n");
 fputs($connection, " ");

 /*$j = 0;
 while ($j < 16) {
 fgets($connection, 128);
  $j++;
}*/
 stream_set_timeout($connection, 2);
 $timeoutCount = 0;
 while (!feof($connection))
	{
	$content = fgets($connection, 128);
	$content = str_replace("\r", '', $content);
	$content = str_replace("\n", "", $content);
	print $content."\n";


	$info = stream_get_meta_data($connection);
	if ($info['timed_out']) 
		{ // If timeout of connection info has got a value, the router not returning any output.
		$timeoutCount++; // We want to count, how many times repeating.
		} 

	if ($timeoutCount >2)
		{ // If repeating more than 2 times,
		break;   // the connection terminating..
		}
	} 
}
echo "End.\r\n";
?>
