<?php foreach($usersStatistics as $stat)
	{
		$stringToPrint = utf8_decode("INSERT INTO user_archive VALUES (NULL,`".
			$stat->getId()."`,`".
			$stat->getAge()."`,`".
			$stat->getCreatedAt()."`,`".
			$stat->getCityName()."`,`".
			$stat->getCountry()."`,`".
			$stat->getGender()."`,`".
			$stat->getSeg()."`,`".
			$stat->getAwareness()."`,`".
			$stat->getCategory()."`,`").
			$fileName."`);";
			
		echo $stringToPrint."\n" ;
	
	}?>
	
<?php foreach($usesStatistics as $stat)
	{
		$stringToPrint = utf8_decode("INSERT INTO imputation_archive VALUES (NULL,`".
			$stat->getImputationDate()."`,`".
			$stat->getImputationType()."`,`".
			$stat->getDuration()."`,`".
			$stat->getDesignation()."`,`".
			$stat->getPrice()."`,`".
			$stat->getMethodOfPayment()."`,`".
			$stat->getBuildingDesignation()."`,`".
			$stat->getRoomDesignation()."`,`".
			$stat->getComputerName()."`,`".
			$stat->getComputerTypeOfConnexion()."`,`".
			$stat->getUserArchiveId()."`);");
			
		echo $stringToPrint."\n" ;
		
	}?>
	
<?php 
	$filename = "stats_".date("d/m/y")."_".date("G:i:s").".sql";
	$filesize = sizeof($filename);
	header("Pragma: no-cache");
	header("Expires: 0");
	header("Cache-Control: no-cache, must-revalidate");
	header("Content-Type: text/html; charset=UTF-8");
	header("Content-Type: application/force-download; name=\"".$filename."\"");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: " .$filesize );
	header("Content-Disposition: attachment; filename=\"".$filename."\"");
?>