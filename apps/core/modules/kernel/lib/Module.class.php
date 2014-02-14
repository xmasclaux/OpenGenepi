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

define('APPLICATIONS_INTERFACE',ProjectConfiguration::guessRootDir().'/apps/ApplicationsCommonInterface.class.php');
require_once(APPLICATIONS_INTERFACE);

class Module{
	
	/**
	 * The Module name
	 * @var string
	 */
	private $module_name;
	
	/**
	 * A short description for the module.
	 * @var string
	 */
	private $module_description;
	
	/**
	 * A boolean representing whether a module is compulsory or not.
	 * @var bool
	 */
	private $compulsory;
	
	/**
	 * 
	 * @var string
	 */
	private $menu_entry_name;
	
	/**
	 * Constructor of the class Module.
	 * @param string $name
	 * @param boolean $compulsory
	 * @param string $menu_entry_name
	 */
	public function __construct($name, $compulsory, $menu_entry_name){
		$this->module_name = $name;
		$this->compulsory = $compulsory;
		$this->menu_entry_name = $menu_entry_name;
	}
	
	/**
	 * Gets the module name.
	 */
	public function getModuleName(){
		return $this->module_name;
	}
	
	/**
	 * 
	 * @param unknown_type $name
	 */
	public function setMenuEntryName($name){
		$this->menu_entry_name = $name;
	}
	
	/**
	 * 
	 */
	public function getMenuEntryName(){
		return $this->menu_entry_name;
	}
	
	/**
	 * Check whether the module is compulsory or not.
	 */
	public function isCompulsory(){
		return $this->compulsory;
	}
	
	public function setModuleDescription($description){
		$this->module_description = $description;
	}
	
	public function getModuleDescription(){
		return $this->module_description;
	}
	
	/**
	 * An alias to ApplicationsCommonInterface->getModuleProperty() method.
	 * Its hide the instanciation, the property name and the path to the template.
	 * @param string $module_name
	 */
	public static function isCompulsoryByName($module_name){
		
		$interface = new ApplicationsCommonInterface(ProjectConfiguration::guessRootDir().'/apps/');
		if($interface->getModuleProperty($module_name,'compulsory') == 'yes'){
			return true;
		}else{
			return false;
		}
		
	}
	
	/**
	 * Loads the module.
	 */
	public function load($path, $menu_entry){
		$interface = new ApplicationsCommonInterface(ProjectConfiguration::guessRootDir().'/apps/');
		if(empty($menu_entry) || is_null($menu_entry)){
			$this->setMenuEntryName(null);
			return $interface->addModule($this->module_name,$path,'null');
		}else{
			$this->setMenuEntryName($menu_entry);
			return $interface->addModule($this->module_name,$path, $menu_entry);
		}
	}
	
	/**
	 * Unload module.
	 */
	public function unLoad(){
		$interface = new ApplicationsCommonInterface(ProjectConfiguration::guessRootDir().'/apps/');
		return $interface->removeModule($this->module_name);
	}
	
	
	/**
	 * Force to unload the module.
	 * @param string $module_name
	 */
	public static function unLoadForce($module_name){
		$interface = new ApplicationsCommonInterface(ProjectConfiguration::guessRootDir().'/apps/');
		return $interface->removeModule($module_name);
	}
	
	
	/**
	 * This method checks whether a module is installed or not.
	 * @param $module_name: a string that represents the name of the module.
	 */
	public static function isInstalled($module){
		
		$table = Kernel::getInstalledModules();
		
		foreach($table as $app_name => $modules){
			foreach($modules as $module_name => $module_path){
				if($module_name == $module){
					return true;
				}
			}
		}
		return false;
	}
	
	
	/**
	 * 
	 * @param array $dep_table
	 * @param string $module
	 */
	public static function hasUnsatisfiedDependencies($dep_table, $module){

		foreach($dep_table as $mod => $dep_list){
			foreach($dep_list as $dep){
				if(KernelInstance::isUnsatisfied($module, $dep)){
					return true;
				}
			}
		}
		return false;
	}
	
	
	
	/**
	 * 
	 * @param array $modules
	 */
	public static function checkAll($dep_table, $modules_obj){
		
		$active_modules_list = array();

		//Construct an array of the activated modules names:
		foreach($modules_obj as $module_obj){
			$active_modules_list[$module_obj->getModuleName()] = $module_obj->getModuleName();
		}

		//foreach activated module, get its dependencies:
		foreach($modules_obj as $module_obj){
			$module_deps = $dep_table[$module_obj->getModuleName()];
			
			//foreach dependencies, check if it's present in the active_modules_list:
			$deps_ok = true;
			foreach($module_deps as $dep){
				$deps_ok = $deps_ok && in_array($dep,$active_modules_list);
			}
			
			if($deps_ok){
				//if the dependencies are ok, get the description of the module:
				$module_obj->setModuleDescription(Kernel::askForDescription($module_obj->getModuleName()));
				$modules_obj_copy[$module_obj->getModuleName()] = $module_obj;
			}else{
				unset($active_modules_list[$module_obj->getModuleName()]);
			}
		}
		return $modules_obj_copy;
	}
	
	
	/**
	 * 
	 * @param array $modules_object_list
	 * @param string $module_name
	 */
	public static function isActivated($modules_object_list, $module_name){
		foreach($modules_object_list as $module_obj){
			if($module_obj->getModuleName() == $module_name){
				return true;
			}
		}
		return false;
	}
	
	
	/**
	 *This method parses the 'apps/mgmt/modules' directory and determine which modules aren't installed yet.
	 *@return an array which contains the installables modules. 
	 */
	public static function getInstallables(){

		$installables_modules = array();
		
		//Get the directory:
		$path = ProjectConfiguration::guessRootDir().'/apps/mgmt/modules';
		$module_dir = dir($path);
		
		//Parses the elements of the directory:
		while( false !== ($elem = $module_dir->read())){
			
			//If the element is a directory, is not installed yet and is not hided,
			if(is_dir($path.'/'.$elem) && !self::isInstalled($elem) && !($elem[0] == '.')){
				
				//Add it to the list to return:
				$installables_modules[] = $elem;
			}
		}
		
		return $installables_modules;
	}
}

?>