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

class configurationComponents extends sfComponents
{
	public function executeAddmodule(){
	  

		$this->new_module_name = $this->module_name;
		$this->new_module_menu = $this->menu_entry;
		   
		$this->error_already_installed = false;
		  
		if(!Module::isInstalled($this->new_module_name)){
			$module_obj = new Module($this->new_module_name, false, $this->new_module_menu);
			$module_obj->load('modules/'.$this->new_module_name, $this->new_module_menu);
			   
			$modules = $this->getContext()->get('Modules');
			$modules[] = $module_obj;
			$this->getContext()->set('Modules',$modules);
		  
		}else{
			$this->error_already_installed = true;
		}
	}
	
	
	public function executeRemovemodule(){
  	 
		//Get the currently installed modules from the context:
		$modules = $this->getContext()->get('Modules');
		  
		//Get the name of the module to remove from the request:
		$this->to_remove_module_name = $this->module_name;
		
		//Parse all of the installed modules and unload the correct one:
		foreach($modules as $key => $module){
			if($module->getModuleName() == $this->to_remove_module_name){
				$module->unLoad();
				//remove the module from the tab and update the context:
				unset($modules[$key]);
				$this->getContext()->set('Modules',$modules);
			}
		}
	}
	
	public function executeRemovemoduleforce(){
	   
		//Get the name of the module to remove from the request:
		$this->to_remove_module_name = $this->module_name;
		
		//Force to remove the module from the xml configuration file:
		Module::unLoadForce($this->to_remove_module_name);

	}
}