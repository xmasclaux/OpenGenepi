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

abstract class firstBootLib {
  
  public static function editSecurity()
  {
  	$security = sfYaml::load(ProjectConfiguration::guessRootDir().'/apps/install/config/security.yml');
  	
  	$security['default']['is_secure'] = true;
  	
  	//Dump this php variable to a yaml string:
	$text = sfYaml::dump($security);
			
	//Write this string into the yaml file:
	$security_yaml = fopen(ProjectConfiguration::guessRootDir().'/apps/install/config/security.yml','w+');
	fwrite($security_yaml, $text);
	fclose($security_yaml);
  }
  
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
  
}
?>