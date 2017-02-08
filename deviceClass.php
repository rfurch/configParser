<?php

include "ipClass.php";

// --------------------------------------------------------
// clase base con propiedades y métodos miembro
class devInterface 
	{
	private $name;
	private $description;
	private $vrf;
	private $mpls;
	private $ips=Array();    
	private $mtu;    

	
	function __construct($name)
		{
		$this->name = $name;
		}
		
	function getName()  		{	 return($this->name);		 	}	
	function getVrf()  			{	 return($this->vrf);	 		}	
	function getDescription()  	{	 return($this->description);	}	
	function getMpls()  		{	 return($this->mpls);			}	
	function getMtu() 	 		{	 return($this->mtu);			}	

	function setName($x) 	 	{	 $this->name= $x;				}	
	function setVrf($x) 	 	{	 $this->vrf= $x;				}	
	function setDescription($x)	{	 $this->description = $x;		}	
	function setMpls($x)  		{	 $this->mpls = $x;				}	
	function setMtu($x) 	 	{	 $this->mtu = $x;				}	

	function addIp($ip)
		{
        $this->ips[$ip->getIP()] = $ip; 
		}

	function addIPFromCiscoLine($ciscoLine)
		{
		// split text line by whitespaces:  ip address x.x.x.x y.y.y.y secondary
		$parts = explode(" ", $ciscoLine);
		
		if ( (count($parts) > 2) && $parts[2]==="secondary")
			$secondary=true;
		else
			$secondary=false;
				
		$myIP = new ipAddress( $parts[0], $parts[1], $secondary );
		$this->addIp($myIP);
		}
		
	function dumpInfo()
		{
		echo "Interface: |" . $this->getName() . "| Descr: |" . $this->getDescription() . "| VRF: |". $this->getVrf() . "| MTU: |" . $this->getMtu() . "| MPLS: |" . $this->getMpls() . "|\n";
		foreach($this->ips as &$i)
			{
			echo "   ";
			$i->dumpIP();
			}
		}	

} // fin de la clase 

// --------------------------------------------------------


// clase base con propiedades y métodos miembro
class ciscoDevice 
	{

	private  $devInterfaces=Array();    
	private  $devConfigLines=Array();    
	private  $configFileName=""; 	
	
	
	function ciscoDevice()
		{
		}
		
		
	function ciscoDeviceReadConfig($fname)
		{
		$this->configFileName=$fname;
		$this->devConfigLines=file($fname);
		echo "total lines: " . count($this->devConfigLines); 
		
		
		for ($j=0 ; $j < count($this->devConfigLines) ; $j++)
			{
			//echo "Line #{$line_num} : " . $line;
    
			$n=0;

			if ( ($n=strpos($this->devConfigLines[$j], "interface ")) === 0)
				{
				$interfaceName=trim( substr($this->devConfigLines[$j], strlen("interface ")) );
				$this->parseInterface($j, $interfaceName);
				}
			}			
		}

    //------------------------------------
	function parseInterface($lineNumber, $interfaceName)
		{
		$i=$lineNumber;

		$interfaceDescription="";
		$interfaceVRF="";		
		$interfaceMTU="";		
		$interfaceMpls=false;	

		$myInterface = new devInterface( $interfaceName );

		do 
			{
			if ( ($n=strpos($this->devConfigLines[$i], " description ")) === 0)
				$myInterface->setDescription ( trim( substr($this->devConfigLines[$i], strlen(" description ")) ) );
			else if ( ($n=strpos($this->devConfigLines[$i], " ip vrf forwarding ")) === 0)
				$myInterface->setVrf( trim( substr($this->devConfigLines[$i], strlen(" ip vrf forwarding ")) ) );
			else if ( ($n=strpos($this->devConfigLines[$i], " mpls ip")) === 0)
				$myInterface->setMpls(true);
			else if ( ($n=strpos($this->devConfigLines[$i], " mtu ")) === 0)
				$myInterface->setMtu( trim( substr($this->devConfigLines[$i], strlen(" mtu ")) ) );
			else if ( ($n=strpos($this->devConfigLines[$i], " ip address ")) === 0)
				$myInterface->addIPFromCiscoLine( trim( substr($this->devConfigLines[$i], strlen(" ip address ")) ) );
				
						
			$i++;	
			}while(	substr($this->devConfigLines[$i], 0, 1) == " ") ;
		
		$this->addInterface($myInterface);
							
		
			
		}
		
    //------------------------------------
	function addInterface($interface)
		{
        $this->devInterfaces[$interface->getName()] = $interface; 
		}
		
	function dumpInterfaces()
		{
        
        //var_dump($this->devInterfaces);
        
		foreach($this->devInterfaces as &$value)
			{
			$value->dumpInfo();	
			//echo ("Interface: |{$value->getName()}|{$value->getDescription()}|{$value->getVrf()}|{$value->getMtu()}|{$value->getMpls()}| \n");
			}
		}
		

} // fin de la clase 


// --------------------------------------------------------
// --------------------------------------------------------


// ampliar la clase base
class Espinaca extends ciscoDevice 
	{
	var $concinada = false;

	function Espinaca()
		{
		$this->Verdura(true, "verde");
		}

	function cocinarla()
		{
       $this->concinada = true;
		}

	function está_cocinada()
		{
       return $this->concinada;
		}

} // fin de la clase 

// --------------------------------------------------------
// --------------------------------------------------------

?>


