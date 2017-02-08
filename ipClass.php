<?php

// --------------------------------------------------------
// clase base con propiedades y métodos miembro
class ipAddress 
	{
	private $ip;
	private $mask;
	private $secondary;
	
	function __construct($ip, $mask, $secondary)
		{
		$this->ip = $ip;
		$this->mask = $mask;
		$this->secondary = $secondary;
		}
		
	function getIP()  		 {	 return($this->ip);		 	}	
	function getMask()  	 {	 return($this->mask);	 	}	
	function getSecondary()  {	 return($this->secondary);	}	
		
	function dumpIP()
		{
		echo "IP: |" . $this->getIP() . "| MASK: |" . $this->getMask() . "| Secondary: |" . $this->getSecondary() . "|\n";
		}
		
} // fin de la clase 


// --------------------------------------------------------
// --------------------------------------------------------

?>


