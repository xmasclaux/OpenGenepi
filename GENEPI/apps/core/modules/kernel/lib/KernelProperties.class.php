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

abstract class KernelProperties {
	
/**
	 * An array, indexed by the relative path of the application from the applications root directory (apps),
	 * of arrays of relative path of the module from the application root directory (apps/APP/), themselves indexed by
	 * the name of the module.
	 * @var array.
	 */
	private static $installed_modules;
	
	/**
	 * A string that represents the relative path to the applications root directory (apps) from the directory of
	 * the calling class. You may not modify its value since it's been initialized by the Kernel at the initialization of the
	 * application.
	 * @var string.
	 */
	private static $relative_path_to_apps_root;
	
	/**
	 * The dependencies table is an array, indexed by the modules, of arrays of modules which are required.
	 * @var array
	 */
	private static $dependencies_table;
	
	/**
	 * 
	 * @var array
	 */
	private static $unsatisfied_dependencies = array();
	
	private static $kernel_errors = array();

	private static $html_menu = array();
	
	/**
	 * Store the specified parameter into the static variable $installed_modules.
	 * @param array $modules_list
	 */
	protected static function setInstalledModules($modules_list){
		self::$installed_modules = $modules_list;
	}
	
	/**
	 * A getter for the installed modules array.
	 * @return an array representing the installed modules list.
	 */
	protected static function getInstalledModules(){
		return self::$installed_modules;
	}
	
	/**
	 * Store the specified parameter into the static variable $relative_path_to_apps_root.
	 * @param string $path
	 */
	protected static function setRelativePathToApps($path){
		self::$relative_path_to_apps_root = $path;
	}
	
	/**
	 * A getter for the relative path to applications root directory.
	 * @return a string representing the path to the applications root directory.
	 */
	protected static function getRelativePathToApps(){
		return self::$relative_path_to_apps_root;
	}
	
	/**
	 * Store the specified parameter into the static variable $dependencies_table.
	 * @param array $table
	 */
	protected static function setDependenciesTable($table){
		self::$dependencies_table = $table;
	}
	
	/**
	 * A getter for the dependencies table.
	 * @return an array representing the dependencies table.
	 */
	protected static function getDependenciesTable(){
		return self::$dependencies_table;
	}
	
	/**
	 * Add an unsatisfied dependency to the list.
	 * @param string $name
	 */
	protected static function addUnsatisfiedDependency($module, $required_module){
		self::$unsatisfied_dependencies[$module][] = $required_module;
	}
	
	/** 
	 * A getter for the unsatisfied dependencies list.
	 * @return  an array representing the unsatisfied dependencies list.
	 */
	protected static function getUnsatisfiedDependencies(){
		return self::$unsatisfied_dependencies;
	}
	
	/**
	 * 
	 */
	public static function getErrors(){
		return self::$kernel_errors;
	}
	
	/**
	 * 
	 * @param unknown_type $error_as_string
	 */
	public static function setError($error_as_string){
		self::$kernel_errors[] = $error_as_string;
	}
	
	protected static function setHtmlMenu($html_menu){
		self::$html_menu = $html_menu;
	}
	
	protected static function getHtmlMenu(){
		return self::$html_menu;
	}
	
	/**
	 * 
	 */
	public static function flushErrors(){
		self::$kernel_errors = null;
	}

	/**
	 * 
	 */
	public static function flushAll(){
		self::$installed_modules = null;
		self::$relative_path_to_apps_root = null;
		self::$dependencies_table = null;
		self::$unsatisfied_dependencies = null;
		self::$kernel_errors = null;
	}

}


?>