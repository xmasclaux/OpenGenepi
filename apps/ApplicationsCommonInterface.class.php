<?php 
class ApplicationsCommonInterface {
	
	/**
	 * 
	 * @var string: the configuration file name. A the instanciation of the class,
	 * it is initialized to the class name.
	 */
	private $file = '.xml';

	/**
	 * Constructor of the ApplicationsCommonInterface object
	 * @param $path is the relative path from calling file to join the ApplicationsCommonInterface class.
	 */
	public function __construct($path){
		libxml_use_internal_errors(true);
		$this->file = $path.get_class($this).$this->file;
	}
	
	/**
	 * A getter for the $file parameter.
	 */
	public function getFile(){
		return $this->file;
	}
	
	/**
	 * A setter for the path to join the ApplicationsCommonInterface class.
	 */
	public function setFilePath($path){
		$this->file = $path.'/'.get_class($this).$this->file;
	}
	
	
	/**
	 * This method is charged to return all of the applications currently installed in the project.
	 * @return an array of the applications paths, indexed by the applications names if everything went fine, false otherwise.
	 */
	public function getApplications(){
		
		//Get the xml configuration file as a DOM element:
		if( !($applications = simplexml_load_file($this->getFile())) ){
			Kernel::setError('Error while reading '.$this->getFile().': the file probably doesn\'t exists');
			return false;
		}
		$dom_applications = dom_import_simplexml($applications);
		
		//Initialize the return value:
		$apps = array();
		
		//For each application found in this DOM,
		foreach ($dom_applications->getElementsByTagName('application') as $app){
			
				$nodelist_name = $app->getElementsByTagName('name');
				$nodelist_path = $app->getElementsByTagName('path');
				
				//Get the name and the path of the application:
				$apps[$nodelist_name->item(0)->nodeValue] = $nodelist_path->item(0)->nodeValue;
		}
		return $apps;
	}
	
	
	/**
	 * This method is charged to return all of the modules currently installed for the applications specified as the argument.
	 * @param string $appName
	 * @return an array of the modules paths, indexed by the modules names if everything went fine, false otherwise.
	 */
	public function getModulesByApp($appName){
		
		//Check if the argument is set:
		if(is_null($appName) || empty($appName)) exit('Internal error: An error occured while getting the modules of an unspecified application.');
		
		//Get the xml configuration file as a DOM element:
		if( !($applications = simplexml_load_file($this->getFile())) ){
			Kernel::setError('Error while reading '.$this->getFile().': the file probably doesn\'t exists');
			return false;
		}
		$dom_applications = dom_import_simplexml($applications);
		
		//Parse all of the applications:
		$modules = array();
		foreach ($dom_applications->getElementsByTagName('application') as $app){
			
			$app_nodelist_name = $app->getElementsByTagName('name');
			$app_nodelist_path = $app->getElementsByTagName('path');
			
			//Check if the current application is the one passed as the argument
			if($app_nodelist_name->item(0)->nodeValue == $appName){
				
				//Parse all of the modules of the correct application:
				foreach($app->getElementsByTagName('module') as $module){
					
					$module_nodelist_name = $module->getElementsByTagName('name');
					$module_nodelist_path = $module->getElementsByTagName('path');
					
					//Check if there is only one 'name' and one 'path' specified for the module:
					if(($module_nodelist_name->length > 1) || ($module_nodelist_path->length > 1)){
						Kernel::setError('An error occured while reading the xml configuration file, check '.$this->getFile().'. You may have
				 		specified multiple \'name\' or \'path\' tag for a module.');
					}else{
						//If everything is correct, add it to the installed modules list:
						$modules[$module_nodelist_name->item(0)->nodeValue] = $module_nodelist_path->item(0)->nodeValue.'/';
					}
					
				}
			}
		}
		return $modules;
	}
	
	/**
	 * This method is charged to get the value of the property specified as the second argument for the module 
	 * specified as the first argument.
	 * @param string $module_name
	 * @param string $property_name
	 * @return the value of the property if everything went fine, false otherwise.
	 */
	public function getModuleProperty($module_name,$property_name){
		
		//Check if the two arguments are set:
		if(is_null($module_name) || empty($module_name)){
			if(is_null($property_name) || empty($property_name)){
				Kernel::setError('An error occured while getting an unspecified property of an unspecified module.');
				return false;
			}else{
				Kernel::setError('An error occured while getting an the property '.$property_name.' of an unspecified module.');
				return false;
			}
		}else{
			if(is_null($property_name) || empty($property_name)){
				Kernel::setError('An error occured while getting an unspecified property of the module '.$module_name.'.');
				return false;
			}
		}
		
		$applications = simplexml_load_file($this->getFile());
		$dom_applications = dom_import_simplexml($applications);
		
		//Initialize the return value to false if an error occurs:
		$property_value = false;
		
		/*------------------------------------------------------------------------------------------------------------------------*/
		
		//Parse all the applications:
		foreach ($dom_applications->getElementsByTagName('application') as $application){
			
			//For each application, parse all of the modules and  check if the module is the one passed as the first argument:
			$module_number = 0;
			foreach($application->getElementsByTagName('module') as $module){
				
				if($module->getElementsByTagName('name')->item(0)->nodeValue == $module_name){
					if(isset($dom_module_node)){
						//If the variable $dom_module_node is set, this means we've already found a module whose name
						//matches the module name passed as the first argument. This means there are several modules
						//with the same name.
						exit('Plusieurs module ont le même nom');
					}else{
						$dom_module_node = $application->getElementsByTagName('module')->item($module_number);	
					}
				}else{
					$module_number++;
				}
			}
			
		}
		
		//Check if the module we've found is the correct one:
		if ( $dom_module_node->getElementsByTagName('name')->item(0)->nodeValue != $module_name){
			exit('Module not found');
		}
		
		
		/*------------------------------------------------------------------------------------------------------------------------*/
		
		
		//Check if the property passed as the third argument exists:
		$dom_node_property = $dom_module_node->getElementsByTagName($property_name);
		if( !empty($dom_node_property) ){
			//Check if there is only one property which has the specified name:
			if($dom_node_property->length > 1){
				exit('');
			}else{
				//If everything is ok, get the property value:
				$property_value = $dom_node_property->item(0)->nodeValue;
			}
		}
		
		//Return the property value if the property exists and is unique, false otherwise:
		return $property_value;
	}
	
	
	/**
	 * This method adds a module entry in the application which has the "plugins" id.
	 * (i.e modules added by users)
	 * @param string $name
	 * @param string $path
	 * @param string $menu_entry
	 * @return null if the module name or path is invalid, the xml configuration file is invalid, true otherwise.
	 */
	public function addModule($name, $path, $menu_entry){
		
		//Check the methods parameters:
		if(is_null($name) || empty($name)) return null;
		
		if(is_null($path) || empty($path)) return null;
		
		//Check the object parameter:
		if($this->file == '.xml') return null;
		
		//Load the xml configuration file:
		$applications = simplexml_load_file($this->getFile());
		
		//Add the module, its id, and its properties:
		$new_module = $applications->application[1]->addChild('module');
		$new_module->addAttribute('id',$name);
		$new_module->addChild('name',$name);
		$new_module->addChild('path',$path);
		$new_module->addChild('compulsory','no');
		$new_module->addChild('module_menu_name',$menu_entry);
		
		//Convert the xml string to a DomDocument object and save it:
		$dom = new DomDocument();
		$dom->loadXML($applications->asXML());
		$dom->save($this->getFile());
		
		return true;

	}
	
	/**
	 * This method removes a module entry in the application which has the "plugins" id.
	 * (i.e modules added by users)
	 * @param string $name
	 * @return null if the module name is invalid, the xml configuration file is invalid or if the module doesn't exist, true otherwise.
	 */
	public function removeModule($name){
		
		//Check the method parameter:
		if(is_null($name) || empty($name)) return null;
		
		//Check the object parameter:
		if($this->file == '.xml') return null;
		
		//Load the xml configuration file and convert it to a DomDocument object:
		$applications = simplexml_load_file($this->getFile());
		$dom = new DomDocument();
		$dom->loadXML($applications->asXML());
		
		//Look for the "mgmt" application:
		$dom_plugins = $dom->getElementsByTagName('application')->item(1);
		
		//Look for the module to remove:
		foreach($dom_plugins->getElementsByTagName('module') as $module){
			if($module->getElementsByTagName('name')->item(0)->nodeValue == $name){
				$dom_plugin_to_remove = $module;
			}
		}
		
		//If the module have not been found, return null to indicate that the module we want to remove
		//doesn't exist.
		if(!isset($dom_plugin_to_remove)) return null;
		
		//Remove the module and save the file:
		$dom_plugins->removeChild($dom_plugin_to_remove);
		$dom->save($this->getFile());
		return true;
			
	}
}


?>