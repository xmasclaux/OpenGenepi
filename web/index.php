<?php

if(file_exists('install.php')) unlink('install.php');

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

/*---------------------------------------------------------------------------------------------*/

//Get the core configuration:
$core_configuration = ProjectConfiguration::getApplicationConfiguration('core', 'prod', true);


	//Get all the libs directories for the Kernel module:
	$kernel_libs = $core_configuration->getLibDirs('kernel');
	
	//For each file in each Kernel lib directory, require this file:
	$dir = dir($kernel_libs[0]);
	while( false !== ($file = $dir->read())){
		if(is_file($kernel_libs[0].'/'.$file)){
			require_once($kernel_libs[0].'/'.$file);
		}
	}

/*---------------------------------------------------------------------------------------------*/

$configuration = ProjectConfiguration::getApplicationConfiguration('mgmt', 'prod', true);

	//Get all the libs directories for the Kernel module:
	$conf_libs = $core_configuration->getLibDirs('configuration');
	
	//For each file in each Kernel lib directory, require this file:
	$dir = dir($conf_libs[0]);
	while( false !== ($file = $dir->read())){
		if(is_file($conf_libs[0].'/'.$file)){
			require_once($conf_libs[0].'/'.$file);
		}
	}


//Configure the Management context from the Kernel context:
sfContext::createInstance($configuration, 'mgmt', 'KernelContext')->dispatch();
