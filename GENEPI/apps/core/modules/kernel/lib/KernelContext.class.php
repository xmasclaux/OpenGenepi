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

class KernelContext extends sfContext{
	
	/**
	 * This method override sfContext::initialize. It is charged to initialize the context
	 * of the Management application based on the initialization of the Kernel.
	 * @param sfApplicationConfiguration $configuration
	 */
	public function initialize(sfApplicationConfiguration $configuration){

  		//Initialize the kernel:
  		Kernel::initialize(ProjectConfiguration::guessRootDir().'/apps/');

  		//Build the dependencies table:
  		Kernel::buildDependenciesTable();
  		
  		//Build the installed modules:
  		$modules = Kernel::buildInstalledModules();
  		
  		//Get the currently installed cultures:
  		parent::set('InstalledCultures',Kernel::getInstalledCultures($configuration));
  		
  		//Check if everything is ok,
  		//and make the status as an attribute of the calling application context:
  		parent::set('KernelStatus', Kernel::check());
  		
  		parent::set('DependenciesErrors', Kernel::getUnsatisfiedDependencies());
  		
  		//Create the instance of the Kernel, containing only the installed modules list and the dependencies table,
  		//and make it as an attribute of the calling application context:
  		parent::set('Kernel', Kernel::createInstance());
  		
  		parent::set('Modules', Module::checkAll(parent::get('Kernel')->getDependenciesTable() ,$modules));
		
  		
  		//Launch the 'classical' intialization process: the sfContext::initialize() method:
  		parent::initialize($configuration);

	}
}

?>