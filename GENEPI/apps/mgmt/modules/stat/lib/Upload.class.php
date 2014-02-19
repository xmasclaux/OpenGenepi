<?php

/**
 * Copyright 2010 Pierre Boitel, Bastien Libersa, Paul Périé
 *
 * This file is part of GENEPI.
 *
 * GENEPI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * GENEPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with GENEPI. If not, see <http://www.gnu.org/licenses/>.
 */

abstract class Upload {
	
  public static function editUploadParameters()
  {
  	$dom_doc = new DOMDocument();
	$dom_doc->load(ProjectConfiguration::guessRootDir().'/config/upload.parameters.xml');
	
	$dom_parameters = $dom_doc->documentElement;
	
	$new_node = $dom_parameters->getElementsByTagName('value')->item(0);
	$new_node->nodeValue = date('m/d/Y');
	
	$dom_doc->importNode($new_node, true);
	
	$to_remove = $dom_parameters->getElementsByTagName('value')->item(0);
	
	$dom_parameters->replaceChild($new_node, $to_remove);
	
	$dom_doc->save(ProjectConfiguration::guessRootDir().'/config/upload.parameters.xml');
  }
	
  public static function readUploadParameters()
  {
  	
  	libxml_use_internal_errors(true);
  	
  	//Get the xml configuration file as a DOM element:
	if( !($parameters = simplexml_load_file(ProjectConfiguration::guessRootDir().'/config/upload.parameters.xml')) ){
		return false;
	}
	
	$dom_parameters = dom_import_simplexml($parameters);
  	
  	$last_upload = $dom_parameters->getElementsByTagName('value')->item(0)->nodeValue;
  	
  	return $last_upload;
  	
  }
  
  public static function exportToSql($last_upload)
  {
  
  	$structure = Doctrine::getTable('Structure')
      	->createQuery('a')
      	->fetchOne();
  	
  	$fileName = $structure->getName().'&'.$structure->getAddress()->getStreet().'&'.$structure->getAddress()->getAddressCity()->getPostalCode().'&'.$structure->getAddress()->getAddressCity()->getName().'&'.$structure->getAddress()->getAddressCity()->getAddressCountry()->getName();
  	
  	$fileName = Upload::rewrite(utf8_decode($fileName));
  	
  	$fp = fopen(ProjectConfiguration::guessRootDir().'/web/uploads/stats/'.$fileName.'.sql','a+');
  	
  	$usersStatistics = Doctrine_Query::create()
		    ->select('*')
		    ->from('UserArchive')
		    ->execute();
		    
	foreach($usersStatistics as $stat)
	{
		$stringToPrint = utf8_decode("INSERT INTO user_archive VALUES (NULL,`".
			$stat->getAge()."`,`".
			$stat->getCreatedAt()."`,`".
			$stat->getCityName()."`,`".
			$stat->getCountry()."`,`".
			$stat->getGender()."`,`".
			$stat->getSeg()."`,`".
			$stat->getAwareness()."`,`".
			$stat->getCategory()."`,`").
			$fileName."`);";
			
		fwrite($fp,$stringToPrint."\n");
	
	}
  	
  	$usesStatistics = Doctrine_Query::create()
		    ->select('*')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array(date('Y-m-d', strtotime($last_upload)),date('Y-m-d')))
	  		->execute();
	  		
	foreach($usesStatistics as $stat)
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
			
		fwrite($fp,$stringToPrint."\n");
		
	}
	
	fclose($fp);
  }
  
  public static function rewrite($in) {
	$search = array ('@[éèêëÊË]@i','@[àâäÂÄ]@i','@[îïÎÏ]@i','@[ûùüÛÜ]@i','@[ôöÔÖ]@i','@[ç]@i','@[ ]@i');
	$replace = array ('e','a','i','u','o','c','_');
	return preg_replace($search, $replace, $in);
  }
  
	
}