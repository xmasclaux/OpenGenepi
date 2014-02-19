<?php

// this check prevents access to debug front controllers that are deployed by accident to production servers.
// feel free to remove this, extend it or make something more sophisticated.
/*if (!in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')))
{
  die('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}*/


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

/*---------------------------------------------------------------------------------------------*/

//Get the core configuration:
$core_configuration = ProjectConfiguration::getApplicationConfiguration('core', 'dev', true);


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

$configuration = ProjectConfiguration::getApplicationConfiguration('mgmt', 'dev', true);

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
