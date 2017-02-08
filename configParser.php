<?php

include "deviceClass.php";

// Script example.php
$shortopts  = "";
$shortopts .= "f:";  // Valor obligatorio
$shortopts .= "v:"; // Valor opcional
$shortopts .= "abc"; // Estas opciones no aceptan valores

$longopts  = array(
    "required:",     // Valor obligatorio
    "optional::",    // Valor opcional
    "option",        // Sin valores
    "opt",           // Sin valores
);
$options = getopt($shortopts, $longopts);
if ( !isset ($options["f"]) || ! trim($options["f"]) )
	{
		echo "\n\n Filename requiered! \n\n";
		exit;
	}

$myDevice = new ciscoDevice();

$myDevice->ciscoDeviceReadConfig($options["f"]);






echo "\n\n";

/*
foreach ($lines as $line_num => $line) 
	{
    echo "Line #{$line_num} : " . $line;
    
    $pattern="interface ";
	$n=0;

	if ( ($n=strpos($line, $pattern)) === 0)
		{
		$myInterface = new devInterface( trim( substr($line, strlen($pattern)) ), trim($line) );
						
		var_dump($myInterface);
		echo $line;	
		$myDevice->addInterface($myInterface);
		}
	}	
	*/
	
$myDevice->dumpInterfaces();	
    


exit;


/*$handle = fopen($options["f"], "r");
if ($handle) 
	{
    while (($line = fgets($handle)) !== false) 
		{
		$pattern="interface ";
		$n=0;

		echo "\n File Pos: " . ftell($handle);
		
		if ( ($n=strpos($line, $pattern)) === 0)
			{
			$myInterface = new devInterface( trim( substr($line, strlen($pattern)) ), trim($line) );
						
						
	        var_dump($myInterface);

						
			echo $line;	
			$myDevice->addInterface($myInterface);
			
			}
		// process the line read.
		}

    fclose($handle);
	} 	
else 
	{
    // error opening the file.
	} 
	
	
$myDevice->dumpInterfaces();	
 
 */
 
?>
