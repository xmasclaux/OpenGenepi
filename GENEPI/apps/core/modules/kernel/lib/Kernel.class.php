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

define('KERNEL_PROPERTIES',dirname(__FILE__).'/KernelProperties.class.php');
define('KERNEL_INSTANCE',dirname(__FILE__).'/KernelInstance.class.php');

require_once(KERNEL_PROPERTIES);
require_once(KERNEL_INSTANCE);

abstract class Kernel extends KernelProperties{
	
	/**
	 * This method override KernelProperties::getInstalledModules() to enable other classes
	 * of the Kernel library to get the list of the installed modules.
	 * @return an array representing the installed modules list.
	 */
	public static function getInstalledModules(){
		return parent::getInstalledModules();
	}
	
	/**
	 * This method override KernelProperties::getDependenciesTable() to enable other classes
	 * of the Kernel library to get the dependencies table.
	 * @return an array representing the dependencies table.
	 */
	public static function getDependenciesTable(){
		return parent::getDependenciesTable();
	}
	
	/** 
	 * A getter for the unsatisfied dependencies list.
	 * @return  an array representing the unsatisfied dependencies list.
	 */
	public static function getUnsatisfiedDependencies(){
		return parent::getUnsatisfiedDependencies();
	}

	
	/**
	 * This method is charged to read the tree of the applications root directory (apps) in order to determine which
	 * applications is installed and which modules are installed and belong to theses applications.
	 * This method must be called only at startup.
	 * @param string $path_to_apps : the path (relative or absolute) to join the ApplicationsCommonInterface class.
	 * @return an array which is meant to be stored into the static variable $installed_modules.
	 */
	public static function initialize($path_to_apps){

		parent::flushErrors();
		//Set the path to the root apps directory:
  		parent::setRelativePathToApps($path_to_apps);
  		
  		//Require the ApplicationsCommonInterface:
  		if(file_exists(parent::getRelativePathToApps().'ApplicationsCommonInterface.class.php')){
  			require_once(parent::getRelativePathToApps().'ApplicationsCommonInterface.class.php');
  		}else{
  			self::setError('Error while reading '.parent::getRelativePathToApps().'ApplicationsCommonInterface.class.php'.
							 ': the file probably doesn\'t exists');
  			parent::setInstalledModules(null);
  			return null;
  		}
  		
  		
		//Join the interface and instanciate it:
		$interface = new ApplicationsCommonInterface(parent::getRelativePathToApps());
		
		//Get the installed applications:
		if( !($installed_apps = $interface->getApplications()) ){
			parent::setInstalledModules(null);
			return false;
		}
		
		//For each installed application, get the installed modules:
		$apps_modules = array();
		foreach($installed_apps as $appName => $appPath){
			if($modules = $interface->getModulesByApp($appName) ){
				$apps_modules[$appPath] = $modules;
			}
		}
		
		parent::setInstalledModules($apps_modules);
	}
	
	/**
	 * This method is charged to check if everything went fine during the initialization process.
	 * @return an array which contains the error messages to display
	 */
	public static function check(){
		
		$error_msg = array();
		//Check if there is at least one module installed:
		if(is_null(self::getInstalledModules())){
			$error_msg['install'] = 'There are no installed modules.';
		}
		
		//Check if the dependencies table have been correctly filled:
		if(is_null(self::getDependenciesTable())){
			$error_msg['table'] = 'The dependencies table could not be initialized.';
		}
		
		//Check others errors
		if(self::getErrors() != NULL){
			$error_msg['conf'] = self::getErrors();
		}
		return $error_msg;
	}
	
	/**
	 * This method analyses iteratively all of the installed modules configuration to determine their 
	 * dependencies.
	 * @return an array containing a list of the modules required by the module passed as the third argument.
	 */
	protected static function askForDependencies($app_path, $module_path, $module_name){
		
		//Initialize the return value:
		$dependencies_list = array();
		
		//Get the xml configuration file as a DOM element:
		if ( !($dependencies = 
				simplexml_load_file(Kernel::getRelativePathToApps().$app_path.$module_path.$module_name.'.dependencies.xml')) ){
					
			self::setError('Error while reading '.Kernel::getRelativePathToApps().$app_path.$module_path.$module_name.'.dependencies.xml'.
							 ': the file probably doesn\'t exists');
			return null;
		}
		$dom_dependencies = dom_import_simplexml($dependencies);
		
		//For each dependency found in this configuraton file,
		foreach ($dom_dependencies->getElementsByTagName('dependency') as $dependency){
			
			//Check if there is only one module required per dependency:
			$dependency_module_list = $dependency->getElementsByTagName('module');
			if($dependency_module_list->length > 1) {
				//Otherwise, an error occurs:
				self::setError('An error occured while reading the xml configuration file, check '.Kernel::getRelativePathToApps().$app_path.$module_path.$module_name.'.dependencies.xml'
				.'. You may have specified multiple \'module\' tag for a dependency.');
				return null;
			}
			
			//Check if the required dependency is installed:
			$dependency_name = $dependency->getElementsByTagName('module')->item(0)->nodeValue;
			if(Module::isInstalled($dependency_name)){
				$dependencies_list[] = $dependency_name;
			}else{
				//Otherwise, add it also to the required dependencies list:
				self::addUnsatisfiedDependency($module_name, $dependency_name);
				$dependencies_list[] = $dependency_name;
			}
		}
		return $dependencies_list;
	}
	
	/**
	 * 
	 * @param string $module_name
	 */
	public static function askForDescription($name){
		
		if(is_null($installed_apps = Kernel::getInstalledModules()) ) {
			return null;
		}
		
		foreach ($installed_apps as $app_path => $modules){
			foreach ($modules as $module_name => $module_path) {
				if( $module_name == $name ){
					
					//Get the xml description file as a DOM element:
					if ( !($description = 
							simplexml_load_file(Kernel::getRelativePathToApps().$app_path.$module_path.$module_name.'.description.xml')) ){
					
						self::setError('Error while reading '.Kernel::getRelativePathToApps().$app_path.$module_path.$module_name.'.description.xml'.
							 ': the file probably doesn\'t exists');
						return null;
					}
					$dom_description = dom_import_simplexml($description);
					
					return $dom_description->nodeValue;
				}
			}
		}
	}
	
	
	/**
	 * This method is charged to build the dependencies table of the application.
	 * The dependencies table is an array, indexed by the modules names, of arrays
	 * of the other modules which are necessary to the first.
	 */
	public static function buildDependenciesTable(){
		
		$table = array();
		
		if(is_null($installed_apps = Kernel::getInstalledModules()) ) {
			return null;
		}
		foreach ($installed_apps as $app_path => $modules){
			foreach ($modules as $module_name => $module_path) {
				if( !is_null($dep = self::askForDependencies($app_path, $module_path, $module_name)) ){
					$table[$module_name] = $dep;
				}
			}
		}
		
		parent::setDependenciesTable($table);
	}
	
	/**
	 * This method is charged to build the Modules object in order to add them to the context of the application.
	 * @return an array of Modules objects.
	 */
	public static function buildInstalledModules(){
		$modules = array();
		$path = parent::getRelativePathToApps();
		
		//Check if there was errors previously:
			//Concerning the path to the ApplicationsCommonInterface:
		if(empty($path) || is_null($path)){
			self::setError('An error occured while reading the ApplicationsCommonInterface, please check the correct location of this file.');
			return false;
		}
			//Concerning the ApplicationsCommonInterface class file itself:
		if(!file_exists($path.'ApplicationsCommonInterface.class.php')){
			//If so, an error already occured previously, so just return false:
			return false;
		}
		
		//If everything went fine so far, instanciate the ApplicationsCommonInterface:
		$interface = new ApplicationsCommonInterface($path);
		
		//Check if the init of the dependencies table went fine:
		if(is_null($table = parent::getDependenciesTable())){
			return false;
		}
		//For each module in the dependencies table,
		foreach($table as $module_name => $dependencies_list ){
			//Check if the module has unsatisfied dependencies:
			if(!Module::hasUnsatisfiedDependencies(self::getDependenciesTable(), $module_name)){
				//print($module_name.'<br>');
				//If not, it's ok to build it:
				//Check whether it's compulsory:
				if($interface->getModuleProperty($module_name,'compulsory') == 'yes'){
					if(($menu_entry = $interface->getModuleProperty($module_name,'module_menu_name')) != 'null'){
						$modules[] = new Module($module_name,true, $menu_entry);
					}else{
						$modules[] = new Module($module_name,true, null);
					}
				}else{
					if(($menu_entry = $interface->getModuleProperty($module_name,'module_menu_name')) != 'null'){
						$modules[] = new Module($module_name,false, $menu_entry);
					}else{
						$modules[] = new Module($module_name,false, null);
					}
				}
			}
		}
		return $modules;
	}
	
	/**
	 * This method is charged to get the cultures currently installed in the application.
	 * It parses the mgmt/i18n/ directory and determine which languages are available.
	 * @param sfApplicationConfiguration $configuration
	 * @return an array of symbols (such as 'en', 'fr', 'de',...) representing the languages currently installed.
	 */
	public static function getInstalledCultures(sfApplicationConfiguration $configuration){
		
		//Get the i18n directories and check if there's any, or it's not empty:
		$i18n_dirs = $configuration->getI18NGlobalDirs();
		if(is_null($i18n_dirs) || empty($i18n_dirs)){
			self::setError('An error occured while opening the languages folder. Check if the i18n directory exists.');
			return null;
		}
		
		$installed_cultures = array();
		//Get the first one: apps/mgmt/i18n/
		$i18n_dir = dir($i18n_dirs[0]);
		
		//Get all of the subdirectories but ignore '.' and '..' directories
		while( false !== ($culture_dir = $i18n_dir->read())){
			if(is_dir($i18n_dirs[0].'/'.$culture_dir) && ($culture_dir[0] != '.')){
				$installed_cultures[] = $culture_dir;
			}
		}
		
		return $installed_cultures;
	}
	
	/**
	 * This method is charged to instanciate an KernelInstance object in order to add it the application context.
	 * It must be called at the end of the initialization process, otherwise, the error messages may not be correct.
	 */
	public static function createInstance(){
		$kernel_instance = new KernelInstance(
			self::getInstalledModules(),
			self::getDependenciesTable(),
			self::getUnsatisfiedDependencies());
			
		return $kernel_instance;
	}
}
?>