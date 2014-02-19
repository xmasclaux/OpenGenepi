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

require_once dirname(__FILE__).'/KernelProperties.class.php';

class KernelInstance extends KernelProperties{
	
	/**
	 * Constructor of an instance of the Kernel of the application.
	 * It defines and enables only
	 * @param array $installed_modules
	 * @param array $dependencies_table
	 */
	public function __construct($installed_modules, $dependencies_table, $unsatisfied_dependencies){
		$this->installed_modules = $installed_modules;
		$this->dependencies_table = $dependencies_table;
		$this->unsatisfied_dependencies = $unsatisfied_dependencies;
	}
	
	/**
	 * This method override KernelProperties::getDependenciesTable() to enable other modules
	 * to get the dependencies table.
	 * @return an array representing the dependencies table.
	 */
	public static function getDependenciesTable(){
		return parent::getDependenciesTable();
	}
	
	/**
	 * This method override KernelProperties::getInstalledModules() to enable other modules
	 * to get the list of the installed modules.
	 * @return an array representing the installed modules list.
	 */
	public static function getInstalledModules(){
		return parent::getInstalledModules();
	}
	
	/**
	 * 
	 */
	public static function getUnsatisfiedDependencies(){
		return parent::getUnsatisfiedDependencies();
	}
	
	/**
	 * 
	 */
	public static function getHtmlMenu(){
		return parent::getHtmlMenu();
	}
	
	/**
	 * 
	 * @param string $module
	 * @param string $dependency
	 */
	public static function isUnsatisfied($module, $dependency){
		$un_dep = self::getUnsatisfiedDependencies();
		
		foreach($un_dep as $mod => $un_dep_list){
			if($mod == $module){
				foreach($un_dep_list as $un_dep){
					if($un_dep == $dependency){
						return true;
					}
				}
			}
		}
		return false;
	}
	
	
/*---------------------------------------------------------LOG LIBRARY----------------------------------------------------------------------------*/
	
	
	/**
	 * Adds a log specified by its level and its message. If the level doesn't exist yet, a new file will be created.
	 * @param string $log_level
	 * @param string $log_as_string
	 */
	public function addLog($log_level, $log_as_string){
		
		try{
			//Check arguments:
			if(is_null($log_level) || is_null($log_as_string) || empty($log_level) || empty($log_as_string)){
				return false;
			}
			
			//Get the current date and time and create the string representing the absolute file path:
			$date = date('D, d-m-Y, H:i:s > ');
			$file_name = ProjectConfiguration::guessRootDir().'/log/'.$log_level.'.log';
			
			//Check if the file path is not null:
			if(is_null($file_name)){
				return false;
			}
			
			//Open this file:
			$file = fopen($file_name,'a+');
			
			//Check if the file descriptor is not null:
			if(is_null($file)){
				return false;
			}
			
			//Write in the file and finally close it:
			fputs($file,"\n".$date.$log_as_string);
			fclose($file);
			
			return true;
			
		}catch(sfFileException $e){
			//If an sfFileException has been catched, just return false:
			return false;
		}
	}
	
	/**
	 * Adds multiple logs represented by an array 'level' => 'message'.
	 * @param array $logs
	 */
	public function addMultipleLog($logs){
		
		//Check the argument:
		if(is_null($logs) || empty($logs)) return false;
		
		$ret = true;
		//For each log found in the argument, call the addLog method:
		foreach($logs as $log_level => $log_msg){
			$ret = $ret && $this->addLog($log_level, $log_msg);
		}
		return $ret;
	}
	
	/**
	 * Adds the log of the array in the second argument corresponding to the number passed in the first argument.
	 * @param int $choice_nb
	 * @param array $logs_as_array
	 */
	public function addLogChoice($choice_nb, $logs_as_array){

		//Check the arguments:
		if(($choice_nb < 0) || is_null($logs_as_array) || empty($logs_as_array)) return false;
		
		$i = 0;
		foreach($logs_as_array as $level => $log){
			if($i == $choice_nb){
				return $this->addLog($level,$log);
			}
			$i++;
		}
		return false;
	}
	
	/**
	 * Adds the first log if the condition is true, the second otherwise.
	 * @param boolean $condition
	 * @param array $logs_as_array
	 */
	public function addLogIf($condition, $logs_as_array){

		//Check the arguments:
		if(is_null($logs_as_array) || empty($logs_as_array)){
			return false;
		}
		
		if($condition == true){
			//If the condition is true, add the first log:
			return $this->addLogChoice(0,$logs_as_array);
		}else if(!$condition){
			//Otherwise, add the second log:
			return $this->addLogChoice(1,$logs_as_array);
		}
	}
	
/*---------------------------------------------------------LOG LIBRARY----------------------------------------------------------------------------*/
}
?>