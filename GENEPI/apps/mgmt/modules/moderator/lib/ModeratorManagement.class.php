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

abstract class ModeratorManagement {
	
	const MODERATOR_SUFFIX = '_default.parameters.xml';
	
	const MODERATOR_CONFIG_DIR = '/config/';
	
	/**
	 * This function creates the xml configuration file for the default parameters of the new moderator.
	 * @param string $moderator_prefix
	 */
	public static function createXML($moderator_prefix){
		
		$file_name = $moderator_prefix.self::MODERATOR_SUFFIX;
		$config_dir = ProjectConfiguration::guessRootDir().self::MODERATOR_CONFIG_DIR;
		
		$absolute_file_path = $config_dir.$file_name;
		
		$file = fopen($absolute_file_path, 'w');
		
		$xml = new DefaultParametersFile($absolute_file_path, 'UTF-8');
		$file_content = $xml->buildEntireFile();
		
		fwrite($file, $file_content);
		fclose($file);
		
	}
	
	/**
	 * This function deletes the xml configuration file for the default parameters of the moderator
	 * @param string $moderator_prefix
	 */
	public static function deleteXML($moderator_prefix){
		
		$file_name = $moderator_prefix.self::MODERATOR_SUFFIX;
		$config_dir = ProjectConfiguration::guessRootDir().self::MODERATOR_CONFIG_DIR;
		
		$absolute_file_path = $config_dir.$file_name;
		
		unlink($absolute_file_path);
	}
	
	
	/**
	 * 
	 * @param unknown_type $login_to_check
	 */
	public static function checkForDoubloon($login_to_check){
		
		$existing_login = Doctrine_Core::getTable('Login')
					->findOneByLogin($login_to_check);
					
		
		if($existing_login){
			return false;
		}else{
			return true;
		}
		
	}
	
	
	/**
	 * 
	 * @param unknown_type $login
	 */
	public static function getPasswordAsMd5($login){
		
		$login_entry = Doctrine_Core::getTable('Login')
					->findOneById($login);
					
		return $login_entry['password'];
	}
	
	
	/**
	 * 
	 * @param unknown_type $pass
	 */
	public static function asMd5WithPrefix($pass){
		return  md5("X21LE7PI12".$pass);
	}
	
	
}